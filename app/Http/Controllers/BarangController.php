<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('inventories')
            ->join('vendors', 'inventories.id_vendor', '=', 'vendors.id')
            ->select('inventories.*', 'vendors.name as vendor_name');

        if ($request->filled('search')) {
            $query->where('inventories.name', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->get();

        return view('kelolaBarang.index', compact('barangs'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('kelolaBarang.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $barangData = $request->input('barang');

        foreach ($barangData as $data) {
            Inventory::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'identifier' => $data['identifier'],
                'id_vendor' => $data['vendor'],
            ]);
        }

        return redirect('/barangs')->with('success', 'Semua barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        $barang = Inventory::with('vendor')->findOrFail($id);
        return view('barangs.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Inventory::findOrFail($id);
        $vendors = Vendor::all();
        return view('kelolaBarang.edit', compact('barang', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'identifier' => 'required|string',
            'id_vendor' => 'required|exists:vendors,id',
        ]);

        $barang = Inventory::findOrFail($id);
        $barang->update([
            'name' => $request->name,
            'description' => $request->description,
            'identifier' => $request->identifier,
            'id_vendor' => $request->id_vendor,
        ]);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Inventory::findOrFail($id);
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus!');
    }
}
