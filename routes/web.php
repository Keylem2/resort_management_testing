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
    Route::resource('bookings', FinanceBookingController::class)->only(['index', 'show']);
    Route::post('/bookings/{booking}/approve', [FinanceBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [FinanceBookingController::class, 'reject'])->name('bookings.reject');
    Route::resource('inventory-requests', FinanceInventoryController::class)->only(['index', 'show']);
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
