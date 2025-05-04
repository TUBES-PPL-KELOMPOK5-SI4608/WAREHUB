<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/admin/dashboard', [DashboardController::class, 'getDashboardAdmin'])->name('dashboard.admin');

Route::resource('admin/barangs', BarangController::class);

Route::get('/dashboard-manager', [DashboardController::class, 'index'])->name('dashboard-manager');

Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard-manager', [DashboardController::class, 'indexManager'])->name('dashboard-manager');
Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard-admin');

