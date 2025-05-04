<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardAdmin()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        return view('dashboard.admin');
    }
}