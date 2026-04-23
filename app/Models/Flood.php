<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Flood extends Model
{
    /** @use HasFactory<\Database\Factories\FloodFactory> */
    use HasFactory;

    // #[Fillable()]

    protected $fillable = ['description', 'lat', 'lng', 'image', 'status', 'province', 'regency', 'district', 'village', 'image_storage_url', 'user_id'];

    protected function casts()
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isAnon(): bool
    {
        return is_null($this->user_id);
    }

    // protected static function boot(): void
    // {
    //     parent::boot();

    //     static::creating(function ($flood) {
    //         // Logika Status: Jika bukan admin (atau role tertentu), status default PENDING
    //         // Asumsi: request user bisa diakses via app('auth->user()) atau di-set manual
    //         if (Auth::check() && Auth::user()->role !== 'USER') {
    //             $flood->status = 'NEW'; // Atau 'NEW' sesuai logika bisnis
    //         }
    //     });
    // }

    public static function STATUSES()
    {
        return [
            'PENDING',
            'NEW',
            'AID_DISPATCHED',
            'AID_ARRIVED',
            'RESOLVE'
        ];
    }
}
