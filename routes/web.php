<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\Admin\AdminReviewController;


use App\Models\User;
use App\Models\Layanan;
use App\Models\Barber;
use App\Models\Galeri;
use App\Http\Controllers\ReviewController;

// ================== HALAMAN UTAMA ==================
Route::get('/', function () {
    $layanans = Layanan::all();
    $barbers = Barber::all();
    $galleries = Galeri::all(); // <--- pakai nama model Galeri

    $reviews = \App\Models\Review::with(['booking.user', 'barber'])
    ->latest()
    ->take(6)
    ->get();

    return view('welcome', compact('layanans', 'barbers', 'galleries', 'reviews'));
})->name('welcome');


// ================== LOGIN / REGISTER ==================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ================== REGISTER ==================
Route::post('/register', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:5',
    ]);

    User::create([
        'name' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
})->name('register.post');

Route::get('/barber/{barber}', [BarberController::class, 'show'])
    ->name('komentar');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------r------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // CRUD
    Route::resource('layanan', LayananController::class);
    Route::resource('barber', BarberController::class);
    Route::resource('galeri', GaleriController::class);

    // Booking admin
    Route::post('/bookings/{id}/confirm', [AdminController::class, 'confirm'])
        ->name('bookings.confirm');

    Route::post('/bookings/{id}/reject', [AdminController::class, 'reject'])
        ->name('bookings.reject');

    Route::post('/bookings/clear', [AdminController::class, 'clearAllBookings'])
        ->name('bookings.clear');

    // ✅ INI WAJIB ADA
    Route::get('/reviews', [AdminReviewController::class, 'index'])
        ->name('reviews.index');
});


/* 
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Booking
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/booking/{booking}/payment', [BookingController::class, 'showPayment'])
        ->name('booking.payment.show');

    Route::post('/booking/{booking}/payment', [BookingController::class, 'uploadPayment'])
        ->name('booking.payment.upload');

    Route::post('/booking/clear-history', [BookingController::class, 'clearHistory'])
        ->name('booking.clearHistory');

    // Profil
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::post('/profil/photo', [ProfileController::class, 'updatePhoto'])->name('profil.update.photo');
    Route::post('/profil/update', [ProfileController::class, 'updateProfile'])->name('profil.update');

    // Review user
    Route::get('/review/{booking}', [ReviewController::class, 'create'])
        ->name('review.create');

    Route::post('/review', [ReviewController::class, 'store'])
        ->name('review.store');
});