<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Lapangan CRUD
    Route::get('/lapangan', [AdminController::class, 'lapanganIndex'])->name('lapangan.index');
    Route::post('/lapangan', [AdminController::class, 'lapanganStore'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [AdminController::class, 'lapanganEdit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [AdminController::class, 'lapanganUpdate'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [AdminController::class, 'lapanganDestroy'])->name('lapangan.destroy');
    
    // Jadwal CRUD
    Route::get('/jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::post('/jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [AdminController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');
    
    // Booking management
    Route::get('/booking', [AdminController::class, 'bookingIndex'])->name('booking.index');
    Route::post('/booking/{id}/approve', [AdminController::class, 'bookingApprove'])->name('booking.approve');
    Route::post('/booking/{id}/reject', [AdminController::class, 'bookingReject'])->name('booking.reject');
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{lapangan_id}', [UserController::class, 'createBooking'])->name('booking.create');
    Route::post('/booking', [UserController::class, 'storeBooking'])->name('booking.store');
    Route::get('/pembayaran/{booking_id}', [UserController::class, 'pembayaran'])->name('pembayaran.create');
    Route::post('/pembayaran/{booking_id}', [UserController::class, 'storePembayaran'])->name('pembayaran.store');
});
