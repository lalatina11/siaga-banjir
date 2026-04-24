<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use App\Models\FloodAid;
use App\Models\FloodAidItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FloodAidController extends Controller
{
    public function getFloodById($id)
    {
        try {
            return Flood::findOrFail($id);

        } catch (\Throwable $th) {
            return null;
        }
    }

    public function create(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'items.*.name' => ['required', 'string', 'min:3', 'max:255'],
                    'items.*.price' => [
                        'required',
                        'integer',
                        'min:1000',
                        function ($attribute, $value, $fail) {
                            if ($value % 1000 !== 0) {
                                $fail($attribute . 'Harga harus kelipatan dari Rp 1000,-');
                            }
                        },
                    ]
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $flood = $this->getFloodById($id);
            if ($flood == null) {
                return redirect()->back()->withErrors('Laporan banjir tidak valid');
            }

            $floodAid = FloodAid::create(['flood_id' => $flood->id])->first();

            $flood->update(['flood_aid_id' => $floodAid->id, 'status' => 'AID_DISPATCHED']);

            foreach ($validated['items'] as $item) {
                FloodAidItem::create([
                    'flood_aid_id' => $floodAid->id,
                    'name' => $item->name ?? $item['name'],
                    'price' => $item->price ?? $item['price'],
                ]);
            }


            return redirect()->back();

        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
}
