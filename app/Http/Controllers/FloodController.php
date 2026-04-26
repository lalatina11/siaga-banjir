<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Laravolt\Avatar\Avatar;

class FloodController extends Controller
{
    protected $floodAidController;

    public function __construct(FloodAidController $floodAidController)
    {
        $this->floodAidController = $floodAidController;
    }

    private function getFloodbyId($id)
    {
        try {
            $flood = Flood::where('id', $id)->with(['user', 'floodAid.floodAidItems'])->first();
            if ($flood != null) {
                return $flood;
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function index()
    {
        $floods = Flood::with('user')->where('status', '!=', 'PENDING')->orderBy('updated_at', 'desc')->get();
        return Inertia::render('home', ['floods' => $floods]);
    }

    public function show($id)
    {
        $flood = $this->getFloodbyId($id);
        if ($flood == null) {
            return Inertia::render('error/not-found-error');
        }
        if ($flood->status === "PENDING" && (request()->user() == null || request()->user()->role === "USER")) {
            return redirect()->route('home');
        }
        return Inertia::render('single-flood', ['flood' => $flood]);
    }

    public function newFloodPage()
    {
        return Inertia::render('new-flood');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'description' => ['string', 'nullable'],
                'lat' => ['required', 'numeric', 'between:-90,90'],
                'lng' => ['required', 'numeric', 'between:-180,180'],
                'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
                'province' => ['required', 'string', 'min:3', 'max:64'],
                'regency' => ['required', 'string', 'min:3', 'max:64'],
                'district' => ['required', 'string', 'min:3', 'max:64'],
                'village' => ['required', 'string', 'min:3', 'max:64'],
                'is_anon' => ['required', 'string', 'in:true,false'],
            ], [
                'lat.required' => 'Koordinat Latitude wajib diisi.',
                'lat.numeric' => 'Koordinat Latitude harus berupa angka.',
                'lat.between' => 'Koordinat Latitude harus berada di antara -90 hingga 90.',

                'lng.required' => 'Koordinat Longitude wajib diisi.',
                'lng.numeric' => 'Koordinat Longitude harus berupa angka.',
                'lng.between' => 'Koordinat Longitude harus berada di antara -180 hingga 180.',

                'image.required' => 'Foto kejadian wajib diunggah.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Format gambar hanya boleh jpeg, jpg, png, atau webp.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB.',

                'province.required' => 'Nama provinsi wajib diisi.',
                'province.string' => 'Nama provinsi harus berupa teks.',
                'province.min' => 'Nama provinsi minimal 3 karakter.',
                'province.max' => 'Nama provinsi maksimal 64 karakter.',

                'regency.required' => 'Nama kabupaten/kota wajib diisi.',
                'regency.string' => 'Nama kabupaten/kota harus berupa teks.',
                'regency.min' => 'Nama kabupaten/kota minimal 3 karakter.',
                'regency.max' => 'Nama kabupaten/kota maksimal 64 karakter.',

                'district.required' => 'Nama kecamatan wajib diisi.',
                'district.string' => 'Nama kecamatan harus berupa teks.',
                'district.min' => 'Nama kecamatan minimal 3 karakter.',
                'district.max' => 'Nama kecamatan maksimal 64 karakter.',

                'village.required' => 'Nama desa wajib diisi.',
                'village.string' => 'Nama desa harus berupa teks.',
                'village.min' => 'Nama desa minimal 3 karakter.',
                'village.max' => 'Nama desa maksimal 64 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            if ($validated['is_anon'] !== "true") {
                $validated['user_id'] = $request->user()->id;
            }

            $file = $validated['image'];

            $storageUrl = $file->store("flood/image", 'public');
            $url = asset(Storage::url($storageUrl));
            $validated['image_storage_url'] = $storageUrl;
            $validated['image'] = $url;

            if ($request->user()->role != 'USER') {
                $validated['status'] = 'NEW';
            }

            Flood::create($validated);
            return redirect()->route('home');
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

    public function accept($id)
    {
        try {
            $flood = $this->getFloodbyId($id);
            if ($flood != null) {
                $flood->update(['status' => 'NEW']);
                return redirect()->back();
            }
            return redirect()->back()->withErrors('Gagal update laporan banjir');
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

    public function markAsResolved($floodAidId)
    {
        try {
            $floodAid = $this->floodAidController->getFloodAidById($floodAidId);
            if (!$floodAid) {
                return redirect()->back()->withErrors('Data bantuan banjir tidak valid');
            }
            $flood = $this->getFloodbyId($floodAid->flood_id);
            if (!$flood) {
                return redirect()->back()->withErrors('Laporan banjir tidak valid');
            }
            $flood->update(['status' => 'RESOLVED']);
            return redirect()->back();
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
    public function delete($id)
    {
        try {
            $flood = $this->getFloodbyId($id);
            if (!$flood) {
                return redirect()->back()->withErrors('Laporan banjir tidak valid');
            }
            $flood->delete();
            return redirect('/dashboard/superadmin');
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
}
