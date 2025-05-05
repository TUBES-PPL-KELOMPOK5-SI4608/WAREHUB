<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $vendors = Vendor::all(); 
        return view('vendors.index', compact('vendors', 'user')); 
    }


    public function create()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        return view('vendors.create', compact('user')); 
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        Vendor::create([
            'name' => $request->name,
            'contact' => $request->contact
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit(Vendor $vendor)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $vendor->update([
            'name' => $request->name,
            'contact' => $request->contact
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendors.index' )->with('success', 'Vendor berhasil dihapus.');
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendors.index', compact('vendor'));
    }

}