<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard-admin', function () {
    return view('dashboard.admin');
})->name('dashboard-admin');

Route::resource('barangs', BarangController::class);



Route::get('/dashboard-manager', [DashboardController::class, 'index'])->name('dashboard-manager');
