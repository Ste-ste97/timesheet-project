<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProfileController;

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

    Route::post('/users/mass-destroy', [UserController::class, "massDestroy"])->name('users.massDestroy');
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::get('/profile', [ProfileController::class, "index"])->name('profile');
    Route::patch('/profile/update-profile', [ProfileController::class, "updateProfile"])->name('profile.update');
    Route::patch('/profile/update-password', [ProfileController::class, "updatePassword"])->name('profile.password');
});

require __DIR__ . '/auth.php';
