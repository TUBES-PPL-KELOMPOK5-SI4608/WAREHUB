<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\stock_out;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class StockOutController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        $user = auth()->user();
        $query = Inventory::where('status', '!=', 'out')
                  ->where('status', '!=', 'defect');    
    
        $query->where(function ($q) use ($request) {
           $q->where('name', 'like', '%' . $request->search . '%')
             ->orWhere('identifier', 'like', '%' . $request->search . '%');
        });
    
        $inventories = $query->paginate(12);
    
        return view('stockouts.index', compact('inventories', 'user'));
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

    public function bulkStore(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $ids = $request->input('selected_ids', []);

        if (count($ids) === 0) {
            return redirect()->route('stockouts.index')->with('success', 'Tidak ada barang yang dipilih.');
        }

        foreach ($ids as $id) {
            stock_out::create([
                'id_inventory' => $id,
                'status' => 'done',
                'date' => now()->format('Y-m-d'),
                'created_with' => Auth::user()->username,
            ]);

            $inventory = Inventory::findOrFail($id);
            $inventory->status = 'out';
            $inventory->save();
        }

        return redirect()->route('stockouts.index')->with('success', 'Semua barang berhasil dikeluarkan!');
    }

    public function confirm(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->route('stockouts.index')->with('success', 'Tidak ada barang yang dipilih.');
        }
    
        $barang = Inventory::whereIn('id', $ids)->get();
        $grouped = $barang->groupBy('identifier');
    
        $rekapStok = [];
    
        foreach ($grouped as $identifier => $items) {
            $jumlahDikeluarkan = $items->count();
            $jumlahTersedia = Inventory::where('identifier', $identifier)
                ->whereNotIn('id', $ids)
                ->where('status', '!=', 'out')
                ->where('status', '!=', 'defect')
                ->count();
    
            $rekapStok[] = [
                'identifier' => $identifier,
                'akan_dikeluarkan' => $jumlahDikeluarkan,
                'stok_tersedia' => $jumlahDikeluarkan + $jumlahTersedia,
                'sisa_setelah' => $jumlahTersedia
            ];
        }
    
        return view('stockouts.confirm', compact('barang', 'rekapStok'));
    }
    
    

    public function confirmStore(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->route('stockouts.index')->with('success', 'Tidak ada barang yang dipilih.');
        }
    
        $tanggal = now()->format('Y-m-d');
        $username = auth()->user()->username;
    
        foreach ($ids as $id) {
            \App\Models\stock_out::create([
                'id_inventory' => $id,
                'status' => 'done',
                'date' => $tanggal,
                'created_with' => $username,
            ]);
    
            $inventory = \App\Models\Inventory::findOrFail($id);
            $inventory->status = 'out';
            $inventory->save();
        }
    
        $last = \App\Models\stock_out::where('created_with', $username)
                    ->where('date', $tanggal)
                    ->latest('id')
                    ->first();
    
        return redirect()->route('stockouts.suratjalan', [
            'id' => $last->id,
            'recipient_name' => urlencode($request->recipient_name),
            'recipient_address' => urlencode($request->recipient_address),
        ]);
                    
    }
    

    public function generateSuratJalan($id, Request $request)
    {
        $stockout = \App\Models\stock_out::findOrFail($id);
    
        $matchingStockouts = \App\Models\stock_out::where('created_at', $stockout->created_at)
                                ->get();
    
        $inventories = \App\Models\Inventory::whereIn('id', $matchingStockouts->pluck('id_inventory'))->get();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('stockouts.surat_jalan', [
            'stockout' => $stockout,
            'details' => $inventories,
            'recipient_name' => $request->recipient_name ?? '-',
            'recipient_address' => $request->recipient_address ?? '-',
        ]);
    
        return $pdf->download('surat-jalan-' . $stockout->id . '.pdf');
    }
    
    
  
}
