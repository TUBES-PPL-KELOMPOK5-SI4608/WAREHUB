<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/admin/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard-admin');

Route::resource('admin/barangs', BarangController::class);



Route::get('/dashboard-manager', [DashboardController::class, 'index'])->name('dashboard-manager');
