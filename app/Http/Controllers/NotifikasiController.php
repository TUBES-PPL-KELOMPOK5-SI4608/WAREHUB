<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\stock_out;

class NotifikasiController extends Controller
{
    public function index(Request $request)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    $tanggal = $request->input('date');

    $inventories = inventory::query()
        ->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('created_at', $tanggal)
                  ->orWhereDate('updated_at', $tanggal);
        })
        ->latest('created_at')
        ->get();

    $stockOuts = stock_out::with('inventory')
        ->when($tanggal, function ($query) use ($tanggal) {
            $query->whereDate('created_at', $tanggal)
                  ->orWhereDate('updated_at', $tanggal);
        })
        ->latest('created_at')
        ->get();

    return view('notifikasi.index', compact('inventories', 'stockOuts', 'tanggal'));
}
}
