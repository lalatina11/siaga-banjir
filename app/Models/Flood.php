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

    protected $fillable = ['description', 'lat', 'lng', 'image', 'status', 'province', 'regency', 'district', 'village', 'image_storage_url', 'user_id', 'flood_aid_id'];

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

    public function floodAid()
    {
        return $this->hasOne(FloodAid::class, 'flood_id');
    }

    public static function STATUSES()
    {
        return [
            'PENDING',
            'NEW',
            'AID_DISPATCHED',
            'AID_ARRIVED',
            'RESOLVED'
        ];
    }
}
