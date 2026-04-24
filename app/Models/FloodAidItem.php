<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloodAidItem extends Model
{
    /** @use HasFactory<\Database\Factories\FloodAidItemFactory> */
    use HasFactory;

    protected $fillable = ['name', 'price', 'flood_aid_id'];

    public function floodAid()
    {
        return $this->belongsTo(FloodAid::class, 'flood_aid_id');
    }
}
