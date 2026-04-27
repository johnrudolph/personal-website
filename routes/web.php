<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->file(public_path('landing.html')));

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__.'/auth.php';
