<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'reference_number',
        'receipt_path',
        'status',
        'notes'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getAmountFormattedAttribute()
    {
        return '₱' . number_format($this->amount, 2);
    }

    public function getReceiptUrlAttribute()
    {
        return $this->receipt_path ? asset('storage/' . $this->receipt_path) : null;
    }
}