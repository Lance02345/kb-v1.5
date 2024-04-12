<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarHire extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'city_id',
        'model_id',
        'year_of_build',
        'transmission',
        'fuel_type',
        'description',
        'body_type',
        'color',
        'front_img',
        'back_img',
        'right_img',
        'left_img',
        'interiorf_img',
        'interiorb_img',
        'opt_img1',
        'opt_img2',
        'opt_img3',
        'pickup_date',
        'return_date',
        'user_id',
        'package_id',
        'rent_days',
        'price_per_day',
    ];
}
