<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ReturController;


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');

Route::resource('/admin/barangs', BarangController::class);

Route::get('/dashboard-manager', [DashboardController::class, 'index'])->name('dashboard-manager');

Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard-manager', [DashboardController::class, 'indexManager'])->name('dashboard-manager');
Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard-admin');


Route::resource('/admin/vendors', VendorController::class);
Route::post('/admin/barangs/{id}/delete', [BarangController::class, 'destroy'])->name('barangs.forceDelete');
Route::get('/admin/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

Route::get('/admin/barang/out', [StockOutController::class, 'index'])->name('stockouts.index');
Route::post('/admin/barangs/{id}/out/post', [StockOutController::class, 'store'])->name('stockouts.store');

Route::get('/admin/returs', [ReturController::class, 'index'])->name('returs.index');
Route::post('/admin/returs', [ReturController::class, 'store'])->name('returs.store');
Route::delete('/admin/returs/{id}', [ReturController::class, 'destroy'])->name('returs.destroy');
Route::post('/admin/returs/{id}/status', [ReturController::class, 'updateStatus'])->name('returs.updateStatus');
Route::get('/admin/barang/minimum', [BarangController::class, 'minimum'])->name('barangs.minimum');


Route::fallback(function () {
    if (auth()->check()) {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/login');
    }
});


