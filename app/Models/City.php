<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['city', 'county_id', 'latitude', 'longitude'];

    public function county() {
        return $this->belongsTo('App\Models\County');
    }
}
