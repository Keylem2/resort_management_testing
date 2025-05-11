<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'check_in_time',
        'check_out_time',
        'nights',
        'guests',
        'total_amount',
        'deposit_amount',
        'status',
        'payment_status',
        'payment_method',
        'finance_notes',
'rejection_reason',
'approved_by',
'approved_at',
'rejected_by',
'rejected_at',
    ];

    protected $casts = [
        'check_in' => 'datetime:Y-m-d',
        'check_out' => 'datetime:Y-m-d',
        'check_in_time' => 'datetime:H:i:s',
        'check_out_time' => 'datetime:H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function inventoryItems()
    {
        return $this->belongsToMany(Inventory::class)
            ->withPivot('quantity_used', 'replaced')
            ->withTimestamps();
    }

    public function getFullCheckInAttribute()
    {
        return Carbon::parse($this->check_in->format('Y-m-d') . ' ' . $this->check_in_time);
    }

    public function getFullCheckOutAttribute()
    {
        return Carbon::parse($this->check_out->format('Y-m-d') . ' ' . $this->check_out_time);
    }

    public function deductInventory()
    {
        $defaultAmenities = [
            'Mattress' => 2,
            'Pillow' => 4,
            'Towel' => 2,
            'Soap' => 1,
            'Shampoo' => 1,
            'Conditioner' => 1,
            'Lotion' => 1,
            'Bottled Water' => 2,
            'Tissue Roll' => 1
        ];

        foreach ($defaultAmenities as $itemName => $quantity) {
            $inventory = Inventory::where('name', $itemName)->first();
            
            if ($inventory) {
                $this->inventoryItems()->attach($inventory->id, [
                    'quantity_used' => $quantity
                ]);
                
                // Only deduct stock if consumable
                if ($inventory->is_consumable) {
                    $inventory->decrement('stock_quantity', $quantity);
                }
            }
        }
    }
}