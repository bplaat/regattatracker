<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoatsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminBoatsController;
use App\Models\User;

// Home page
Route::view('/', 'home')->name('home');

// Normal routes
Route::middleware([ 'auth' ])->group(function () {
    // Boats
    Route::get('/boats', [ BoatsController::class, 'index' ])->name('boats.index');
    Route::view('/boats/create', 'boats.create')->name('boats.create');
    Route::post('/boats', [ BoatsController::class, 'store' ])->name('boats.store');
    Route::get('/boats/{boat}/edit', [ BoatsController::class, 'edit' ])->name('boats.edit');
    Route::get('/boats/{boat}/delete', [ BoatsController::class, 'delete' ])->name('boats.delete');
    Route::get('/boats/{boat}', [ BoatsController::class, 'show' ])->name('boats.show');
    Route::post('/boats/{boat}', [ BoatsController::class, 'update' ])->name('boats.update');

    // Settings
    Route::view('/settings', 'settings')->name('settings');
    Route::post('/settings/change_details', [ SettingsController::class, 'changeDetails' ])->name('settings.change_details');
    Route::post('/settings/change_password', [ SettingsController::class, 'changePassword' ])->name('settings.change_password');

    // Auth logout
    Route::get('/auth/logout', [ AuthController::class, 'logout' ])->name('auth.logout');
});

// Admin routes
Route::middleware([ 'admin' ])->group(function () {
    // Admin home
    Route::view('/admin', 'admin.home')->name('admin.home');

    // Admin users
    Route::get('/admin/users', [ AdminUsersController::class, 'index' ])->name('admin.users.index');
    Route::get('/admin/users/{user}', [ AdminUsersController::class, 'show' ])->name('admin.users.show');

    // Admin boats
    Route::get('/admin/boats', [ AdminBoatsController::class, 'index' ])->name('admin.boats.index');
    Route::get('/admin/boats/{boat}', [ AdminBoatsController::class, 'show' ])->name('admin.boats.show');
});

// Guest routes
Route::middleware([ 'guest' ])->group(function () {
    // Auth login
    Route::view('/auth/login', 'auth.login')->name('auth.login');
    Route::post('/auth/login', [ AuthController::class, 'login' ]);

    // Auth register
    Route::view('/auth/register', 'auth.register')->name('auth.register');
    Route::post('/auth/register', [ AuthController::class, 'register' ]);
});
