<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\stock_out as BarangKeluar;

use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function create(Request $request) {
        $stock_id = $request->stock_id;
        $selectedStock = Stock::find($stock_id);
        $stocks = Stock::all(); // untuk dropdown

        return view('barang_keluar.create', compact('stocks', 'selectedStock'));
    }

    public function store(Request $request) {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'date_out' => 'required|date',
            'status' => 'required|in:shipping,pending,book'
        ]);

        BarangKeluar::create([
            'stock_id' => $request->stock_id,
            'date_out' => $request->date_out,
            'status' => $request->status
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function index() {
        $barangKeluars = BarangKeluar::with('stock')->latest()->get();
        return view('barang_keluar.index', compact('barangKeluars'));
    }
}
