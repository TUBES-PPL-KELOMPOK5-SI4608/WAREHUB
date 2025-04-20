<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventory;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = inventory::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        // Ambil semua data hasil filter/search
        $barangs = $query->get();

        return view('kelolaBarang.index', compact('barangs'));
    }

    // Tampilkan form tambah barang
    public function create()
    {
        return view('kelolaBarang.create');
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $barangData = $request->input('barang');
    
        foreach ($barangData as $index => $data) {
            $picture1Path = null;
            if ($request->hasFile("barang.$index.picture_1")) {
                $picture1Path = $request->file("barang.$index.picture_1")->store('barang_pictures', 'public');
            }
    
            $picture2Path = null;
            if ($request->hasFile("barang.$index.picture_2")) {
                $picture2Path = $request->file("barang.$index.picture_2")->store('barang_pictures', 'public');
            }
    
            // Simpan langsung ke tabel inventories menggunakan Eloquent
            
            Inventory::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'identifier' => $data['identifier'],
                'id_vendor' => $data['vendor'],
                'picture_1' => $picture1Path,
                'picture_2' => $picture2Path,
                'created_with' => 'fia'
            ]);
        }
    
        return redirect('/barangs')->with('success', 'Semua barang berhasil ditambahkan!');
    }

    // Tampilkan detail satu barang
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barangs.show', compact('barang'));
    }

    // Tampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barangs.edit', compact('barang'));
    }

    // Update data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'nullable',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->except('_token'));

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus!');
    }
}
