<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class ManagerController extends Controller
{
    public function auditAuth(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();

        if ($user->role !== 'manager') {
            return redirect('/login');
        }

        $from = $request->input('from');
        $to = $request->input('to');
    
        $query = DB::table('activity_logs')
            ->join('users', 'activity_logs.user_id', '=', 'users.id')
            ->where('users.role', 'admin')
            ->select('activity_logs.*', 'users.username as user_name')
            ->orderByDesc('activity_logs.created_at');
    
        if ($from) {
            $query->whereDate('activity_logs.created_at', '>=', $from);
        }
    
        if ($to) {
            $query->whereDate('activity_logs.created_at', '<=', $to);
        }
    
        $logs = $query->paginate(20);
    
        return view('manager.audit-auth', compact('logs', 'from', 'to', 'user'));
    }

    public function auditIn(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();

        if ($user->role !== 'manager') {
            return redirect('/login');
        }

        $from = $request->input('from');
        $to = $request->input('to');

        $items = DB::table('inventories')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('manager.audit-stock-in', compact('items', 'user'));
    }

    public function auditInPdf(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();

        if ($user->role !== 'manager') {
            return redirect('/login');
        }

        $from = $request->input('from');
        $to = $request->input('to');

        $items = DB::table('inventories')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('manager.pdf.audit-stock-in', [
            'items' => $items,
            'from' => $from,
            'to' => $to,
        ]);

        return $pdf->download('audit-barang-masuk.pdf');
    }

    public function auditOut(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();

        if ($user->role !== 'manager') {
            return redirect('/login');
        }

        $from = $request->input('from');
        $to = $request->input('to');

        $items = DB::table('stock_outs')
            ->join('inventories', 'stock_outs.id_inventory', '=', 'inventories.id')
            ->select('stock_outs.*', 'inventories.name as item_name')
            ->when($from, fn($q) => $q->whereDate('stock_outs.created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('stock_outs.created_at', '<=', $to))
            ->orderByDesc('stock_outs.created_at')
            ->paginate(20);

        return view('manager.audit-stock-out', compact('items', 'from', 'to', 'user'));
    }

    public function auditOutPdf(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();

        if ($user->role !== 'manager') {
            return redirect('/login');
        }
        
        $from = $request->input('from');
        $to = $request->input('to');
    
        $items = DB::table('stock_outs')
            ->join('inventories', 'stock_outs.id_inventory', '=', 'inventories.id')
            ->select('stock_outs.*', 'inventories.name as item_name')
            ->when($from, fn($q) => $q->whereDate('stock_outs.created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('stock_outs.created_at', '<=', $to))
            ->orderByDesc('stock_outs.created_at')
            ->get();
    
        $pdf = Pdf::loadView('manager.pdf.audit-stock-out', [
            'items' => $items,
            'from' => $from,
            'to' => $to,
        ]);
    
        return $pdf->download('audit-barang-keluar.pdf');
    }

}
