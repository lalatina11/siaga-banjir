<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloodAid extends Model
{
    /** @use HasFactory<\Database\Factories\FloodAidFactory> */
    use HasFactory;

    protected $fillable = ['flood_id'];

    public function floodAidItems()
    {
        return $this->hasMany(FloodAidItem::class, 'flood_aid_id');
    }

    public function flood()
    {
        return $this->belongsTo(Flood::class, 'flood_id');
    }

}
