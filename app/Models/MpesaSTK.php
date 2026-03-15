<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaSTK extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'mpesa_s_t_k_s';
    protected $casts = [
        'payload' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
