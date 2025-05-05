<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Retur;
use App\Models\stock_out;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();
        $totalProducts = Inventory::count();
        $barangRusak = Retur::count();
        $qtyIn = Inventory::where('status', 'available')->count();
        $qtyOut = stock_out::count();
    
        $kategoriStok = Inventory::select('identifier', DB::raw('count(*) as total'))
                        ->where('status', 'available')
                        ->groupBy('identifier')
                        ->pluck('total', 'identifier');
    
        $bulanMap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    
        $barangMasukPerBulan = Inventory::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->mapWithKeys(fn ($value, $key) => [$bulanMap[(int)$key] => $value]);
    
        $barangKeluarPerBulan = stock_out::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->mapWithKeys(fn ($value, $key) => [$bulanMap[(int)$key] => $value]);
    
        //dd($kategoriStok);
        return view('dashboard.admin', compact(
            'totalProducts', 'barangRusak', 'qtyIn', 'qtyOut',
            'kategoriStok', 'barangMasukPerBulan', 'barangKeluarPerBulan', 'user'
        ));
    }
    

}