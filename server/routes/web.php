<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoatsController;
use App\Http\Controllers\BoatBoatTypeController;
use App\Http\Controllers\BoatUserController;
use App\Http\Controllers\BoatPositionController;
use App\Http\Controllers\SettingsController;

use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminBoatsController;
use App\Http\Controllers\Admin\AdminBoatBoatTypeController;
use App\Http\Controllers\Admin\AdminBoatUserController;
use App\Http\Controllers\Admin\AdminBoatTypesController;
use App\Http\Controllers\Admin\AdminBuoysController;

use App\Models\User;

// Home page
Route::view('/', 'home')->name('home');

// Offline page
Route::view('/offline', 'offline')->name('offline');

// Normal routes
Route::middleware('auth')->group(function () {
    // Boats
    Route::get('/boats', [BoatsController::class, 'index'])->name('boats.index');
    Route::view('/boats/create', 'boats.create')->name('boats.create');
    Route::post('/boats', [BoatsController::class, 'store'])->name('boats.store');
    Route::get('/boats/{boat}/track', [BoatsController::class, 'track'])->name('boats.track')
        ->middleware('can:track,boat');
    Route::get('/boats/{boat}/edit', [BoatsController::class, 'edit'])->name('boats.edit')
        ->middleware('can:update,boat');
    Route::get('/boats/{boat}/delete', [BoatsController::class, 'delete'])->name('boats.delete')
        ->middleware('can:delete,boat');
    Route::get('/boats/{boat}', [BoatsController::class, 'show'])->name('boats.show')
        ->middleware('can:view,boat');
    Route::post('/boats/{boat}', [BoatsController::class, 'update'])->name('boats.update')
        ->middleware('can:update,boat');

    // Boat boat types
    Route::post('/boats/{boat}/boat_types', [BoatBoatTypeController::class, 'create'])->name('boats.boat_types.create')
        ->middleware('can:create_boat_boat_type,boat');

    Route::get('/boats/{boat}/boat_types/{boatType}/delete', [BoatBoatTypeController::class, 'delete'])->name('boats.boat_types.delete')
        ->middleware('can:delete_boat_boat_type,boat');

    // Boat users
    Route::post('/boats/{boat}/users', [BoatUserController::class, 'create'])->name('boats.users.create')
        ->middleware('can:create_boat_user,boat');
    Route::get('/boats/{boat}/users/{user}/update', [BoatUserController::class, 'update'])->name('boats.users.update')
        ->middleware('can:update_boat_user,boat');
    Route::get('/boats/{boat}/users/{user}/delete', [BoatUserController::class, 'delete'])->name('boats.users.delete')
        ->middleware('can:delete_boat_user,boat');

    // Boat Locations
    Route::post('/boats/{boat}/add_location', [BoatPositionController::class, 'create'])->name('boats.location.add_location');

    // Settings
    Route::view('/settings', 'settings', ['countries' => User::COUNTRIES])->name('settings');
    Route::post('/settings/change_details', [SettingsController::class, 'changeDetails'])->name('settings.change_details');
    Route::post('/settings/change_password', [SettingsController::class, 'changePassword'])->name('settings.change_password');

    // Auth logout
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Admin routes
Route::middleware('admin')->group(function () {
    // Admin home
    Route::view('/admin', 'admin.home')->name('admin.home');

    // Admin users
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::view('/admin/users/create', 'admin.users.create', ['countries' => User::COUNTRIES])->name('admin.users.create');
    Route::post('/admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/hijack', [AdminUsersController::class, 'hijack'])->name('admin.users.hijack');
    Route::get('/admin/users/{user}/edit', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('/admin/users/{user}/delete', [AdminUsersController::class, 'delete'])->name('admin.users.delete');
    Route::get('/admin/users/{user}', [AdminUsersController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/{user}', [AdminUsersController::class, 'update'])->name('admin.users.update');

    // Admin boats
    Route::get('/admin/boats', [AdminBoatsController::class, 'index'])->name('admin.boats.index');
    Route::get('/admin/boats/create', [AdminBoatsController::class, 'create'])->name('admin.boats.create');
    Route::post('/admin/boats', [AdminBoatsController::class, 'store'])->name('admin.boats.store');
    Route::get('/admin/boats/{boat}/track', [AdminBoatsController::class, 'track'])->name('admin.boats.track');
    Route::get('/admin/boats/{boat}/edit', [AdminBoatsController::class, 'edit'])->name('admin.boats.edit');
    Route::get('/admin/boats/{boat}/delete', [AdminBoatsController::class, 'delete'])->name('admin.boats.delete');
    Route::get('/admin/boats/{boat}', [AdminBoatsController::class, 'show'])->name('admin.boats.show');
    Route::post('/admin/boats/{boat}', [AdminBoatsController::class, 'update'])->name('admin.boats.update');

    // Admin boat boat types
    Route::post('/admin/boats/{boat}/boat_types', [AdminBoatBoatTypeController::class, 'create'])->name('admin.boats.boat_types.create');
    Route::get('/admin/boats/{boat}/boat_types/{boatType}/delete', [AdminBoatBoatTypeController::class, 'delete'])->name('admin.boats.boat_types.delete');

    // Admin boat users
    Route::post('/admin/boats/{boat}/users', [AdminBoatUserController::class, 'create'])->name('admin.boats.users.create');
    Route::get('/admin/boats/{boat}/users/{user}/update', [AdminBoatUserController::class, 'update'])->name('admin.boats.users.update');
    Route::get('/admin/boats/{boat}/users/{user}/delete', [AdminBoatUserController::class, 'delete'])->name('admin.boats.users.delete');

    // Admin boat types
    Route::get('/admin/boat_types', [AdminBoatTypesController::class, 'index'])->name('admin.boat_types.index');
    Route::view('/admin/boat_types/create', 'admin.boat_types.create')->name('admin.boat_types.create');
    Route::post('/admin/boat_types', [AdminBoatTypesController::class, 'store'])->name('admin.boat_types.store');
    Route::get('/admin/boat_types/{boatType}/edit', [AdminBoatTypesController::class, 'edit'])->name('admin.boat_types.edit');
    Route::get('/admin/boat_types/{boatType}/delete', [AdminBoatTypesController::class, 'delete'])->name('admin.boat_types.delete');
    Route::get('/admin/boat_types/{boatType}', [AdminBoatTypesController::class, 'show'])->name('admin.boat_types.show');
    Route::post('/admin/boat_types/{boatType}', [AdminBoatTypesController::class, 'update'])->name('admin.boat_types.update');

    // Admin buoys
    Route::get('/admin/buoys', [AdminBuoysController::class, 'index'])->name('admin.buoys.index');
    Route::view('/admin/buoys/create', 'admin.buoys.create')->name('admin.buoys.create');
    Route::post('/admin/buoys', [AdminBuoysController::class, 'store'])->name('admin.buoys.store');
    Route::get('/admin/buoys/{buoy}/edit', [AdminBuoysController::class, 'edit'])->name('admin.buoys.edit');
    Route::get('/admin/buoys/{buoy}/delete', [AdminBuoysController::class, 'delete'])->name('admin.buoys.delete');
    Route::get('/admin/buoys/{buoy}', [AdminBuoysController::class, 'show'])->name('admin.buoys.show');
    Route::post('/admin/buoys/{buoy}', [AdminBuoysController::class, 'update'])->name('admin.buoys.update');
});

// Guest routes
Route::middleware('guest')->group(function () {
    // Auth login
    Route::view('/auth/login', 'auth.login')->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Auth register
    Route::view('/auth/register', 'auth.register', ['countries' => User::COUNTRIES])->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});
