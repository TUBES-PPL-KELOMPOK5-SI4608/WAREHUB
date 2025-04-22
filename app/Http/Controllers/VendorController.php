<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
        public function index()
    {
        $vendors = Vendor::all(); // ambil semua data vendor
        return view('vendors.index', compact('vendors')); // kirim ke view
    }


    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        Vendor::create([
            'name' => $request->name,
            'contact' => $request->contact
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    // Menyimpan hasil update
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