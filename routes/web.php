<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\DrawController;
use App\Http\Controllers\PublicDrawController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Draw;

// Routes untuk user yang BELUM login (guest)
Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Routes untuk user yang SUDAH login (auth)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::resource('events', EventController::class);

    // Participants
    Route::prefix('events/{event}')->group(function () {
        Route::get('participants', [ParticipantController::class, 'index'])->name('participants.index');
        Route::get('participants/create', [ParticipantController::class, 'create'])->name('participants.create');
        Route::post('participants', [ParticipantController::class, 'store'])->name('participants.store');
        Route::post('participants/import', [ParticipantController::class, 'import'])->name('participants.import');
        Route::get('participants/export', [ParticipantController::class, 'export'])->name('participants.export');
        Route::delete('participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');

        // Draws
        Route::get('draws', [DrawController::class, 'index'])->name('draws.index');
        Route::get('draws/create', [DrawController::class, 'create'])->name('draws.create');
        Route::post('draws', [DrawController::class, 'store'])->name('draws.store');
        Route::get('draws/{draw}', [DrawController::class, 'show'])->name('draws.show');
        Route::post('draws/{draw}/execute', [DrawController::class, 'execute'])->name('draws.execute');
    });
});

// Public routes
Route::get('/event/{eventSlug}', [PublicDrawController::class, 'event'])->name('public.event');
Route::get('/event/{eventSlug}/draw/{drawSlug}', [PublicDrawController::class, 'show'])->name('public.draw');


// API endpoint untuk real-time updates
Route::get('/api/draw/{draw:slug}/status', function (Draw $draw) {
    return response()->json([
        'status' => $draw->status,
        'winners_count' => $draw->winners()->count(),
        'winners' => $draw->winners()->with('participant')->get()
    ]);
})->name('api.draw.status');

Route::get('/draws/{draw:slug}/winners', [DrawController::class, 'winners'])->name('api.draw.winners');
