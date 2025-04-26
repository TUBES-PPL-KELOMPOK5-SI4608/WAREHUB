<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard-admin', function () {
    return view('dashboard.admin');
})->name('dashboard-admin');

// Ini untuk semua fitur barang
Route::resource('barangs', BarangController::class);

Route::get('/', function () {
    return view('welcome');
});
