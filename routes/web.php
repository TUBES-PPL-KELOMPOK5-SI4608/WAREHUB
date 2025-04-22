<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;

Route::resource('vendors', VendorController::class);



Route::get('/', function () {
    return view('welcome');
});
