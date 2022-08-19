<?php

use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/mass-destroy', [NotificationController::class, 'massDestroy'])->name('notifications.massDestroy');
    Route::resource('notifications', NotificationController::class)->only(['index', 'show']);

    Route::post('/users/mass-destroy', [UserController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::post('/roles/mass-destroy', [RoleController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);

    Route::post('/permissions/store-group', [PermissionController::class, 'storeGroup'])->name('permissions.storeGroup');
    Route::patch('/permissions/{permission}/update-group', [PermissionController::class, 'updateGroup'])->name('permissions.updateGroup');
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::get('/test', TestController::class);

require __DIR__ . '/auth.php';
