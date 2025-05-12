<?php

use App\Models\Booking;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\FrontDesk\BookingController as FrontDeskBookingController;
use App\Http\Controllers\FrontDesk\RoomController as FrontDeskRoomController;
use App\Http\Controllers\Finance\FinanceController;
use App\Http\Controllers\Finance\FinanceBookingController;
use App\Http\Controllers\Finance\FinanceInventoryController;
use App\Http\Controllers\StaffHead\StaffHeadDashboardController;
use App\Http\Controllers\StaffHead\StaffHeadController;
use App\Http\Controllers\StaffHead\TeamController;
use App\Http\Controllers\StaffHead\AttendanceController as StaffHeadAttendanceController;
use App\Http\Controllers\StaffHead\LeaveRequestController as StaffHeadLeaveRequestController;
use App\Http\Controllers\StaffHead\AnnouncementController;
use App\Http\Controllers\HR\HRController;
use App\Http\Controllers\HR\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\RoomController as UserRoomController;
use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Authentication routes
require __DIR__.'/auth.php';

// Email Verification routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// ✅ User-only routes
Route::middleware(['auth', 'verified', 'user_only'])->group(function () {

    // ✅ User Dashboard
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // ✅ User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ User Room Routes
    Route::get('/rooms', [UserRoomController::class, 'index'])->name('user.rooms.index');
    Route::get('/rooms/type/{type}', [UserRoomController::class, 'showByType'])->name('user.rooms.by_type');

    // ✅ User Booking Routes
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [UserBookingController::class, 'index'])->name('index');
        Route::get('/create', [UserBookingController::class, 'create'])->name('create');
        Route::post('/', [UserBookingController::class, 'store'])
            ->middleware(['prevent.duplicate.booking', 'throttle:3,1'])
            ->name('store');
        Route::get('/{booking}', [UserBookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [UserBookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [UserBookingController::class, 'update'])->name('update');
        Route::delete('/{booking}', [UserBookingController::class, 'destroy'])->name('destroy');
        Route::get('/pending/{booking}', [UserBookingController::class, 'pending'])->name('pending');
    });

// ✅ Pending Payments Route (No Single Booking ID)
Route::get('/user/payments/pending', [UserBookingController::class, 'pendingPayment'])->name('user.payments.pending');

// ✅ GCash Payment Route (WITH BOOKING ID)
Route::get('/gcash/payment/{booking_id}', [UserBookingController::class, 'gcashPayment'])->name('gcash.payment');

    // ✅ Clear Form Token Route
    Route::post('/clear-form-token', function() {
        session()->forget('form_token');
        return response()->json(['success' => true]);
    })->name('clear_form_token');
});

// Front Desk routes
Route::middleware(['auth', 'front_desk'])->prefix('frontdesk')->name('frontdesk.')->group(function () {
    Route::get('/dashboard', [FrontDeskBookingController::class, 'index'])->name('dashboard');
    Route::resource('bookings', FrontDeskBookingController::class);
    Route::post('/bookings/{booking}/checkin', [FrontDeskBookingController::class, 'checkIn'])->name('bookings.checkin');
    Route::get('rooms', [FrontDeskRoomController::class, 'index'])->name('rooms.index');
    Route::get('rooms/type/{type}', [FrontDeskRoomController::class, 'showByType'])->name('rooms.by_type');
    Route::get('rooms/available', [FrontDeskRoomController::class, 'available'])->name('rooms.available');
    Route::get('rooms/occupied', [FrontDeskRoomController::class, 'occupied'])->name('rooms.occupied');
});

// Finance routes
Route::middleware(['auth', 'finance'])->prefix('finance')->name('finance.')->group(function () {
    Route::get('/dashboard', [FinanceController::class, 'index'])->name('dashboard');
    Route::get('/bookings/pending', [FinanceBookingController::class, 'pending'])->name('bookings.pending');
    Route::resource('bookings', FinanceBookingController::class)->only(['index', 'show']);
    Route::post('/bookings/{booking}/approve', [FinanceBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [FinanceBookingController::class, 'reject'])->name('bookings.reject');
    Route::resource('inventory-requests', FinanceInventoryController::class)->only(['index', 'show']);
});

// HR routes
Route::middleware(['auth', 'verified', 'hr'])->prefix('hr')->name('hr.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HRController::class, 'dashboard'])->name('dashboard');
    
    // Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    
    // Payroll Routes
Route::prefix('payroll')->name('payroll.')->group(function () {
    Route::get('/', [HRController::class, 'payroll'])->name('index');
    Route::get('/salary', [HRController::class, 'salary'])->name('salary');
    Route::get('/payslip/{employee}', [HRController::class, 'payslip'])->name('payslip'); // ✅ Fixed this line
    Route::get('/run', [HRController::class, 'runPayroll'])->name('run');
    Route::post('/process', [HRController::class, 'processPayroll'])->name('process');
});

     // Events Routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    // Leave Management
    Route::get('/leave', [HRController::class, 'leave'])->name('leave.index');
    Route::get('/leave/create', [HRController::class, 'createLeave'])->name('leave.create');
    Route::post('/leave', [HRController::class, 'storeLeave'])->name('leave.store');
    
    // Employees
    Route::resource('employees', HRController::class)->except(['show']);
    
    // HR Activities
    Route::get('/activities', [HRController::class, 'activities'])->name('activity');
});

// Staff Head routes
Route::middleware(['auth', 'verified', 'staff_head'])->prefix('staff-head')->name('staff_head.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StaffHeadController::class, 'dashboard'])->name('dashboard');
    
    // Team Management
    Route::get('/team', [StaffHeadController::class, 'teamIndex'])->name('team.index');
    Route::get('/team/{employee}', [StaffHeadController::class, 'teamShow'])->name('team.show');
    Route::get('/team/{employee}/edit', [StaffHeadController::class, 'teamEdit'])->name('team.edit');
    Route::put('/team/{employee}', [StaffHeadController::class, 'teamUpdate'])->name('team.update');

    // Attendance Oversight
    Route::get('/attendance', [StaffHeadAttendanceController::class, 'attendanceIndex'])->name('attendance.index');
    Route::post('/attendance/{employee}', [StaffHeadAttendanceController::class, 'attendanceStore'])->name('attendance.store');
    Route::post('/attendance/mark', [StaffHeadAttendanceController::class, 'markAttendance'])->name('attendance.mark');

    // Shift Management
    Route::get('/shifts', [StaffHeadController::class, 'shiftsIndex'])->name('shifts.index');
    Route::get('/shifts/create', [StaffHeadController::class, 'shiftsCreate'])->name('shifts.create');
    Route::post('/shifts', [StaffHeadController::class, 'shiftsStore'])->name('shifts.store');
    Route::get('/shifts/{shift}/edit', [StaffHeadController::class, 'shiftsEdit'])->name('shifts.edit');
    Route::put('/shifts/{shift}', [StaffHeadController::class, 'shiftsUpdate'])->name('shifts.update');
    Route::delete('/shifts/{shift}', [StaffHeadController::class, 'shiftsDestroy'])->name('shifts.destroy');

    // Leave Requests Routes (Fix)
    Route::get('/leave-requests', [StaffHeadLeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/leave-requests/{id}', [StaffHeadLeaveRequestController::class, 'show'])->name('leave.show');
    Route::post('/leave-requests/{id}/approve', [StaffHeadLeaveRequestController::class, 'approve'])->name('leave.approve');
    Route::post('/leave-requests/{id}/reject', [StaffHeadLeaveRequestController::class, 'reject'])->name('leave.reject');
    
    // Announcements Routes
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});



// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('rooms', AdminRoomController::class);
    Route::resource('inventory', InventoryController::class)->except(['show']);
    Route::resource('staff', StaffController::class)->except(['show']);
    Route::get('staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
});

Route::get('/test-logo', function() {
    return view('logo-test', ['logo' => asset('images/logo.png')]);
});

// Route for Virtual Tour Page (Couple Room, or any other room)
Route::get('/rooms/virtual-tour/{type}', function ($type) {
    return view('user.rooms.virtual-tour', compact('type'));
})->name('rooms.virtual_tour');
