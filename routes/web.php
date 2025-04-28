<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;

use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard-admin', function () {
    return view('dashboard.admin');  // Sesuaikan dengan view yang kamu punya
})->name('dashboard-admin');

Route::get('/barangs', [BarangMasukController::class, 'index'])->name('barangs.index');

Route::get('/barangs/create', [BarangMasukController::class, 'create'])->name('barangs.create');
Route::get('/barangs/edit/{id}', [BarangMasukController::class, 'edit'])->name('barangs.edit');
Route::post('/barangs/edit/{id}', [BarangMasukController::class, 'update'])->name('barangs.update');
Route::post('/barangs/create', [BarangMasukController::class, 'store'])->name('barangs.store');
Route::delete('/barangs/{id}', [BarangMasukController::class, 'destroy'])->name('barangs.destroy');
Route::get('/inventories/{id}/history', [BarangMasukController::class, 'showStockHistory'])->name('inventories.history');


Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');



Route::get('/', function () {
    return view('welcome');
});
