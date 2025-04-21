<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard-manager', [DashboardController::class, 'indexManager'])->name('dashboard-manager');
Route::get('/dashboard-admin', [DashboardController::class, 'indexAdmin'])->name('dashboard-admin');
Route::get('/', function () {
    return view('welcome');
});
