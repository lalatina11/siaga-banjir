<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flood extends Model
{
    /** @use HasFactory<\Database\Factories\FloodFactory> */
    use HasFactory;

    #[Fillable(['description', 'lat', 'lng', 'image', 'status', 'province', 'regency', 'district', 'village'])]

    protected function casts()
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public static function STATUSES()
    {
        return [
            'NEW',
            'AID_DISPATCHED',
            'AID_ARRIVED',
            'RESOLVE'
        ];
    }
}
