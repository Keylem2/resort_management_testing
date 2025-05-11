<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type',
        'description',
        'price_per_night',
        'capacity',
        'status',
        'amenities',
        'image_path' // Make sure this is included for room thumbnails
    ];

    // Add this if you want to automatically cast the status
    protected $casts = [
        'price_per_night' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Get the category representative 360° image
    public function getCategory360ImageAttribute()
    {
        return match($this->room_type) {
            'Couple Room' => '360_images/couple_room.jpg',
            'Family Room' => '360_images/family_room.jpg',
            default => null,
        };
    }

    // Check if room is available
    public function getIsAvailableAttribute()
    {
        return $this->status === 'available';
    }
}