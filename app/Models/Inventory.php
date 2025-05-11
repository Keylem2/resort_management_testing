<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory'; // Explicitly set the table name

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_consumable',
        'stock_quantity'
    ];

    protected $casts = [
        'is_consumable' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class)
            ->withPivot('quantity_used', 'replaced')
            ->withTimestamps();
    }
}