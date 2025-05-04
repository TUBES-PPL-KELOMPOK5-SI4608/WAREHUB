<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $barangs = Inventory::with('vendor')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return view('kelolaBarang.index', compact('barangs'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        return view('kelolaBarang.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
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

        return redirect()->route('barangs.index')->with('success', 'Semua barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $barang = Inventory::findOrFail($id);
        return view('barangs.show', compact('barang'));
    }

    public function edit($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $barang = Inventory::findOrFail($id);
        return view('kelolaBarang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $barang = Inventory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_vendor' => 'required|integer',
            'picture_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'picture_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang->update([
            'name' => $validated['name'],
            'identifier' => $validated['identifier'],
            'description' => $validated['description'] ?? null,
            'id_vendor' => $validated['id_vendor'],
        ]);

        if ($request->hasFile('picture_1')) {
            if ($barang->picture_1 && Storage::disk('public')->exists($barang->picture_1)) {
                Storage::disk('public')->delete($barang->picture_1);
            }
            $path1 = $request->file('picture_1')->store('barang_pictures', 'public');
            $barang->update(['picture_1' => $path1]);
        }

        if ($request->hasFile('picture_2')) {
            if ($barang->picture_2 && Storage::disk('public')->exists($barang->picture_2)) {
                Storage::disk('public')->delete($barang->picture_2);
            }
            $path2 = $request->file('picture_2')->store('barang_pictures', 'public');
            $barang->update(['picture_2' => $path2]);
        }

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $barang = Inventory::findOrFail($id);
    
        // Coba hapus gambar 1 kalau ada
        if ($barang->picture_1) {
            try {
                if (Storage::disk('public')->exists($barang->picture_1)) {
                    Storage::disk('public')->delete($barang->picture_1);
                    \Log::info('Gambar 1 dihapus: ' . $barang->picture_1);
                } else {
                    \Log::warning('Gambar 1 tidak ditemukan: ' . $barang->picture_1);
                }
            } catch (\Exception $e) {
                \Log::error('Gagal menghapus Gambar 1: ' . $barang->picture_1 . ' - Error: ' . $e->getMessage());
            }
        }
    
        // Coba hapus gambar 2 kalau ada
        if ($barang->picture_2) {
            try {
                if (Storage::disk('public')->exists($barang->picture_2)) {
                    Storage::disk('public')->delete($barang->picture_2);
                    \Log::info('Gambar 2 dihapus: ' . $barang->picture_2);
                } else {
                    \Log::warning('Gambar 2 tidak ditemukan: ' . $barang->picture_2);
                }
            } catch (\Exception $e) {
                \Log::error('Gagal menghapus Gambar 2: ' . $barang->picture_2 . ' - Error: ' . $e->getMessage());
            }
        }
    
        // Setelah file dihapus atau dilewati error, hapus barang
        $barang->delete();
    
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus!');
    }
    
}
