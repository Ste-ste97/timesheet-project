<?php

use App\Http\Controllers\Dashboard\ProfileController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here you can add all routes for your Laravel Dashboard
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');;

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, "index"])->name('profile');
    Route::patch('/profile/update-profile', [ProfileController::class, "updateProfile"])->name('profile.update');
    Route::patch('/profile/update-password', [ProfileController::class, "updatePassword"])->name('profile.password');
});

require __DIR__ . '/auth.php';
