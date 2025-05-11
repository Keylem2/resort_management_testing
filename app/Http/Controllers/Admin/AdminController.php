<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Inventory;
use App\Models\Payment;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Today's date and yesterday for comparison
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastWeek = Carbon::today()->subWeek();

        // 1. Bookings Metrics
        $todaysBookings = Booking::whereDate('created_at', $today)->count();
        $yesterdaysBookings = Booking::whereDate('created_at', $yesterday)->count();
        $bookingChange = $this->calculatePercentageChange($todaysBookings, $yesterdaysBookings);

        // 2. Room Occupancy Metrics
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;
        
        // Occupancy comparison with last week
        $lastWeekOccupancy = Booking::whereBetween('check_in', [$lastWeek, $lastWeek->copy()->addDay()])
            ->where('status', 'confirmed')
            ->count();
        $occupancyChange = $this->calculatePercentageChange($occupiedRooms, $lastWeekOccupancy);

        // 3. Revenue Metrics
        $todaysRevenue = Payment::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('amount');
        $yesterdaysRevenue = Payment::whereDate('created_at', $yesterday)
            ->where('status', 'completed')
            ->sum('amount');
        $revenueChange = $this->calculatePercentageChange($todaysRevenue, $yesterdaysRevenue);

        // 4. Inventory Alerts
        $inventoryAlerts = Inventory::where('is_consumable', true)
            ->where('stock_quantity', '<', 10)
            ->count();

        // Low stock items for display
        $lowStockItems = Inventory::where('is_consumable', true)
            ->where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        // 5. Recent Bookings
        $recentBookings = Booking::with(['user', 'room', 'payments'])
            ->latest()
            ->take(5)
            ->get();

        // 6. Upcoming Check-ins/Check-outs
        $upcomingCheckIns = Booking::whereDate('check_in', '>=', $today)
            ->whereDate('check_in', '<=', $today->addDays(3))
            ->orderBy('check_in')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'todaysBookings',
            'bookingChange',
            'occupancyRate',
            'occupancyChange',
            'todaysRevenue',
            'revenueChange',
            'inventoryAlerts',
            'lowStockItems',
            'recentBookings',
            'upcomingCheckIns'
        ));
    }

    /**
     * Calculate percentage change between two values
     */
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round(($current - $previous) / $previous * 100, 1);
    }
}