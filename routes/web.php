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
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\IdentifierController;
use App\Models\ActivityLog;




Route::post('/logout', function () {
    $user = Auth::user();

    if ($user && $user->role == 'admin') {
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'logout',
            'description' => 'Admin logged out',
        ]);
    }

    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');

Route::resource('/barangs', BarangController::class);

Route::get('/dashboard-manager', [DashboardController::class, 'index'])->name('dashboard-manager');

Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard-manager', [DashboardController::class, 'indexManager'])->name('dashboard-manager');
Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard-admin');

Route::resource('/vendors', VendorController::class);
Route::post('/barangs/{id}/delete', [BarangController::class, 'destroy'])->name('barangs.forceDelete');
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

Route::get('/barang/out', [StockOutController::class, 'index'])->name('stockouts.index');
Route::post('/barangs/{id}/out/post', [StockOutController::class, 'store'])->name('stockouts.store');
Route::post('/stockouts/bulk', [StockoutController::class, 'bulkStore'])->name('stockouts.bulk');
Route::post('/stockouts/confirm', [StockoutController::class, 'confirm'])->name('stockouts.confirm');
Route::post('/stockouts/confirm/store', [StockoutController::class, 'confirmStore'])->name('stockouts.confirm.store');
Route::get('/stockouts/surat-jalan/{id}', [StockoutController::class, 'generateSuratJalan'])->name('stockouts.suratjalan');



Route::get('/returs', [ReturController::class, 'index'])->name('returs.index');
Route::post('/returs', [ReturController::class, 'store'])->name('returs.store');
Route::delete('/returs/{id}', [ReturController::class, 'destroy'])->name('returs.destroy');
Route::post('/returs/{id}/status', [ReturController::class, 'updateStatus'])->name('returs.updateStatus');
Route::get('/barang/minimum', [BarangController::class, 'minimum'])->name('barangs.minimum');

Route::get('/barang/defect', [BarangController::class, 'defect'])->name('barangs.defect');
Route::put('/barang/defect/update/{id}', [BarangController::class, 'updateDefect'])->name('barang.defectUpdate');

Route::get('/audit/auth', [ManagerController::class, 'auditAuth'])->name('manager.audit');
Route::get('/audit/in', [ManagerController::class, 'auditIn'])->name('manager.audit.in');
Route::get('/audit/in/pdf', [ManagerController::class, 'auditInPdf'])->name('manager.audit.in.pdf');
Route::post('/identifiers/store', [IdentifierController::class, 'store'])->name('identifiers.store');
Route::put('/identifiers/update/{identifier}', [IdentifierController::class, 'update'])->name('identifiers.update');
Route::get('/identifiers/delete/{identifier}', [IdentifierController::class, 'destroy'])->name('identifiers.delete');


Route::get('/audit/out', [ManagerController::class, 'auditOut'])->name('manager.audit.out');
Route::get('/audit/out/pdf', [ManagerController::class, 'auditOutPdf'])->name('manager.audit.out.pdf');




Route::fallback(function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});



