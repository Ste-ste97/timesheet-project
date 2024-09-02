<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\TranslationController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\TotalTimesheetsCostController;
use App\Models\Company;
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

    Route::post('/translations/mass-destroy', [TranslationController::class, 'massDestroy'])->name('translations.massDestroy');
    Route::resource('translations', TranslationController::class)->except(['create', 'edit']);

    Route::post('/companies/mass-destroy', [CompanyController::class, 'massDestroy'])->name('companies.massDestroy');
    Route::resource('companies', CompanyController::class)->except(['create', 'edit']);

    Route::post('/services/mass-destroy', [ServiceController::class, 'massDestroy'])->name('services.massDestroy');
    Route::resource('services', ServiceController::class)->except(['create', 'edit']);

    Route::post('/timesheets/mass-destroy', [TimesheetController::class, 'massDestroy'])->name('timesheets.massDestroy');
    Route::resource('timesheets', TimesheetController::class)->except(['create', 'edit']);

    Route::get('/getCompanies', [TimesheetController::class, 'getCompanies'])->name('timesheets.getCompanies');
    Route::get('/getMonthlyTimeSheets', [TimesheetController::class, 'getMonthlyTimeSheets'])->name('timesheets.getMonthlyTimeSheets');
    Route::get('/getServices', [TimesheetController::class, 'getServices'])->name('timesheets.getServices');


    Route::resource('totalTimesheetsCost', TotalTimesheetsCostController::class)->except(['create', 'edit']);
    Route::get('/changeYear', [TotalTimesheetsCostController::class, 'changeYear'])->name('totalTimesheetsCost.changeYear');

});

Route::get('/test', TestController::class);

Route::post('language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');

require __DIR__ . '/auth.php';
