<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard-admin', function () {
    return view('dashboard.admin');  // Sesuaikan dengan view yang kamu punya
})->name('dashboard-admin');

Route::get('/barangs', [BarangController::class, 'index'])->name('barangs.index');

Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
Route::get('/barangs/edit/{id}', [BarangController::class, 'edit'])->name('barangs.edit');
Route::post('/barangs/edit/{id}', [BarangController::class, 'update'])->name('barangs.update');
Route::post('/barangs/create', [BarangController::class, 'store'])->name('barangs.store');

Route::get('/', function () {
    return view('welcome');
});
