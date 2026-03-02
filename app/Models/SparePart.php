<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

        public const CATEGORIES = [
            'Engine Parts',
            'Transmission',
            'Suspension & Steering',
            'Brakes',
            'Electrical & Lighting',
            'Body & Exterior',
            'Interior',
            'Tyres & Wheels',
            'Filters & Fluids',
            'Accessories',
            'Other',
        ];
    
        protected $fillable = [
            'category',
            'make', 
            'item_name',
            'item_description',
            'condition',
            'location',
            'price',
            'user_id',
            'front_img',
            'back_img',
            'right_img',
        ];

        public function user () {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function listing () {
            return $this->belongsTo(Listing::class, 'user_id');
        }

        public function category() {
            return $this->belongsTo(Category::class, 'category_id');
        }
        public function city () {
            return $this->belongsTo(City::class, 'city_id');
        }
        public function package () {
            return $this->belongsTo(Package::class);
        }

        public function invoice (){
            return $this->belongsTo(Invoice::class, 'invoice_id');
        }
        
           public function vehicles()
        {
            return $this->hasMany(Vehicle::class);
        }
   
    
}
