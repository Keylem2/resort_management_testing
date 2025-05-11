<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
{
    $user = Auth::user();
    
    $upcomingBookings = Booking::with('room')
        ->where('user_id', $user->id)
        ->where('check_in', '>=', now())
        ->orderBy('check_in', 'asc')
        ->get();

    $pastBookings = Booking::with('room')
        ->where('user_id', $user->id)
        ->where('check_out', '<', now())
        ->orderBy('check_out', 'desc')
        ->get();

    $recentBookings = Booking::with('room')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $availableRooms = Room::where('status', 'available')
        ->orderBy('price_per_night')
        ->take(3)
        ->get();

    return view('user.dashboard', [
        'upcomingBookings' => $upcomingBookings,
        'pastBookings' => $pastBookings,
        'recentBookings' => $recentBookings,
        'availableRooms' => $availableRooms
    ]);
}
}