<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Laravolt\Avatar\Avatar;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
            ], [
                // Email
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
                'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
                'email.unique' => 'Alamat email sudah digunakan, silakan gunakan email lain.',

                // Name
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.min' => 'Nama lengkap minimal 3 karakter.',
                'name.max' => 'Nama lengkap maksimal 255 karakter.',

                // Password
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.max' => 'Password maksimal 32 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $emailTaken = User::where('email', $validated['email'])->count();
            if ($emailTaken > 0) {
                return redirect()->back()->withErrors('Email sudah digunakan, silahkan ganti');
            }
            $avatar = new Avatar([]);

            $avatar->create("Mulyono");

            User::create([
                'email' => $validated['email'],
                'name' => $validated['name'],
                'password' => $validated['password'],
                'avatar' => $avatar,
            ]);

            $token = Auth::attempt($validated);

            if (!$token) {
                return redirect()->back()->withErrors('Password tidak valid');
            }
            $request->session()->regenerate();

            return redirect()->route('home');
        } catch (\Exception $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:32'],
            ], [
                // Email
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
                'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',

                // Password
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.max' => 'Password maksimal 32 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $emailTaken = User::where('email', $validated['email'])->count();
            if ($emailTaken < 1) {
                return redirect()->back()->withErrors('Pengguna tidak ditemukan');
            }

            if (!Auth::attempt($validated)) {
                return redirect()->back()->withErrors('Password tidak valid');
            }

            $request->session()->regenerate();

            return redirect()->route('home');
        } catch (\Exception $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->regenerate();

            return redirect()->route('login');
        } catch (\Exception $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

    public function showAuthPage()
    {
        return Inertia::render('auth');
    }

    public function showProfilePage()
    {
        return Inertia::render('profile');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => ['string', 'email', 'max:255', 'nullable'],
                    'name' => ['string', 'max:255', 'nullable'],
                    'avatar' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120', 'nullable'],
                ],
                [
                    // Email
                    'email.email' => 'Format alamat email tidak valid.',
                    'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',

                    // Name
                    'name.string' => 'Nama harus berupa teks.',
                    'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

                    // Avatar
                    'avatar.image' => 'File yang diunggah harus berupa gambar.',
                    'avatar.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
                    'avatar.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB.',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();
            if ($validated['name']) {
                $user->update(['name' => $validated['name']]);
            }
            if ($validated['email']) {
                $user->update(['email' => $validated['email']]);
            }
            if ($validated['avatar']) {
                if ($user->avatar_storage_url) {
                    if (Storage::disk('public')->exists($user->avatar_storage_url)) {
                        Storage::disk('public')->delete($user->avatar_storage_url);
                    }
                }
                $avatar = $validated['avatar'];
                $storageUrl = $avatar->store('user/avatar', 'public');
                $url = asset(Storage::url($storageUrl));
                $validated['avatar_storage_url'] = $storageUrl;
                $validated['avatar'] = $url;
                $user->update([
                    'avatar' => $validated['avatar'],
                    'avatar_storage_url' => $validated['avatar_storage_url'],
                ]);
            }
            return redirect()->route('home');
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

    public function showUpdatePassword()
    {
        return Inertia::render('update-password');
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'current_password' => ['required', 'string', 'min:8', 'max:32'],
                    'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
                ],
                [
                    // Current Password
                    'current_password.required' => 'Password saat ini wajib diisi.',
                    'current_password.string' => 'Password saat ini harus berupa teks.',
                    'current_password.min' => 'Password saat ini minimal 8 karakter.',
                    'current_password.max' => 'Password saat ini maksimal 32 karakter.',

                    // New Password
                    'password.required' => 'Password baru wajib diisi.',
                    'password.string' => 'Password baru harus berupa teks.',
                    'password.min' => 'Password baru minimal 8 karakter.',
                    'password.max' => 'Password baru maksimal 32 karakter.',
                    'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $user = $request->user();

            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->back()->withErrors("Password lama tidak valid!");
            }

            $user->update(['password' => $validated['password']]);
            return redirect()->route('home');

        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

}
