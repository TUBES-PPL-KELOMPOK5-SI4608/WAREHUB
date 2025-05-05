<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\stock_out;
use Illuminate\Support\Facades\Auth;

class StockOutController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::where('status', '!=', 'out');
    
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        $inventories = $query->paginate(12);
    
        return view('stockouts.index', compact('inventories'));
    }
        
    public function store($id){
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        stock_out::create([
            'id_inventory' => $id,
            'status' => 'done',
            'date' => now()->format('Y-m-d'),
            'created_with' => Auth::user()->username,
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->status = 'out';
        $inventory->save();
    
        return redirect()->route('stockouts.index')->with('success', 'Barang berhasil dikeluarkan!');
    }
        
}
