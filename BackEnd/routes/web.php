<?php

use App\Http\Controllers\Admin\PSTourController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TSTourController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->controller(\App\Http\Controllers\Auth\AuthController::class)->group(function () {
    Route::get('/', 'adminLoginPage')->name('login');
    Route::post('/', 'adminLogin');
    Route::get('/logout', 'adminLogout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'home'])->name('dashboard');
    
    Route::controller(UserController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', 'index')->name('user');
            Route::get('/create', 'create')->name('user.create');
            Route::post('/create', 'store')->name('user.store');
            Route::get('/{id}', 'show')->name('user.show');
            Route::get('/edit/{id}', 'edit')->name('user.edit');
            Route::put('/{user}', 'update')->name('user.update');
            Route::delete('/{user}', 'destroy')->name('user.destroy');
        });
    });

    Route::controller(RoomController::class)->group(function () {
        Route::prefix('room')->group(function () {
            Route::get('/', 'index')->name('room.index');
            Route::delete('/{room}', 'destroy')->name('room.destroy');
        });
    });

    Route::controller(PSTourController::class)->group(function () {
        Route::prefix('pstour')->group(function () {
            Route::get('/', 'index')->name('pst.index');
            Route::delete('/{tour}', 'destroy')->name('pst.destroy');
        });
    });

    Route::controller(TSTourController::class)->group(function () {
        Route::prefix('tstour')->group(function () {
            Route::get('/', 'index')->name('tst.index');
            Route::delete('/{tour}', 'destroy')->name('tst.destroy');
        });
    });
});

