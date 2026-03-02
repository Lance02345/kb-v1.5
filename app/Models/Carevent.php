<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carevent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_title',
        'event_description',
        'event_location',
        'event_date',
        'event_time',
        'organizer',
        'event_image',
        'ticket_price',
        'event_duration',
        'user_id',  
        'listing_id',
        'invoice_id',

        ];

        public function user () {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function listing()
        {
            return $this->belongsTo(Listing::class, 'listing_id');
        }

        public function invoice()
        {
            return $this->belongsTo(Invoice::class, 'invoice_id');
        }
}
