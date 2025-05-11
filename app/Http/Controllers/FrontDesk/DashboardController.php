<?php

namespace App\Http\Controllers\FrontDesk;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // Today's bookings count
    $todaysBookings = Booking::whereDate('check_in', Carbon::today())->count();
    
    // Yesterday's bookings for comparison
    $yesterdaysBookings = Booking::whereDate('check_in', Carbon::yesterday())->count();
    $bookingChange = $yesterdaysBookings > 0 
        ? round(($todaysBookings - $yesterdaysBookings) / $yesterdaysBookings * 100, 1)
        : 100;

    // Today's check-ins
    $todaysCheckins = Booking::whereDate('check_in', Carbon::today())
        ->where('status', 'checked_in')
        ->count();

    // Today's check-outs
    $todaysCheckouts = Booking::whereDate('check_out', Carbon::today())
        ->where('status', 'checked_out')
        ->count();

    // Room statistics
    $totalRooms = Room::count();
    $occupiedRooms = Room::where('status', 'occupied')->count();
    $availableRooms = $totalRooms - $occupiedRooms;

    // Recent bookings
    $recentBookings = Booking::with(['user', 'room'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('frontdesk.dashboard', [
        'todaysBookings' => $todaysBookings,
        'bookingChange' => $bookingChange,
        'todaysCheckins' => $todaysCheckins,
        'todaysCheckouts' => $todaysCheckouts,
        'availableRooms' => $availableRooms,
        'occupiedRooms' => $occupiedRooms,
        'recentBookings' => $recentBookings,
    ]);
}
}