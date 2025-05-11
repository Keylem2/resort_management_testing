<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role check methods
    public function isAdmin()
    {
        return $this->usertype === 'admin';
    }

    public function isFinance()
    {
        return $this->usertype === 'finance';
    }

    public function isFrontDesk()
    {
        return $this->usertype === 'front_desk';
    }

    public function isCustomer()
    {
        return $this->usertype === 'user';
    }

    public function isStaff()
    {
        return $this->usertype === 'staff';
    }

    public function isHR()
    {
    return strtolower($this->usertype) === 'hr';
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}