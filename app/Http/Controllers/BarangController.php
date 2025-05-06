<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;


class BarangController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        $user = auth()->user();
    
        $barangs = Inventory::with('vendor')
            ->where(function ($query) {
                $query->where('status', '!=', 'out')
                    ->where('status', '!=', 'defect')
                    ->orWhereNull('status');
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();
    
        return view('kelolaBarang.index', compact('barangs', 'user'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
    
        $vendors = \App\Models\Vendor::select('id', 'name')->get(); 
        return view('kelolaBarang.create', compact('vendors', 'user'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = Auth::user(); 
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
                'status' => 'available',
                'picture_1' => $picture1Path,
                'picture_2' => $picture2Path,
                'created_with' => $user->username,
            ]);
        }

        return redirect()->route('barangs.index')->with('success', 'Semua barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $barang = Inventory::findOrFail($id);
        return view('barangs.show', compact('barang', 'user'));
    }

    public function edit($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
        $barang = Inventory::findOrFail($id);
        $vendors = \App\Models\Vendor::select('id', 'name')->get();
    
        return view('kelolaBarang.edit', compact('barang', 'vendors', 'user'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = Auth::user(); 
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
            'updated_with' => $user->username,
            'status' => $request->status
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
    
        $barang->delete();
    
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function minimum()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();
    
        $identifiers = Inventory::where('status', 'available')
            ->select('identifier')
            ->groupBy('identifier')
            ->selectRaw('identifier, COUNT(*) as qty')
            ->having('qty', '<', 5)
            ->pluck('qty', 'identifier');
    
        return view('kelolaBarang.minimum', compact('identifiers', 'user'));
    }

    public function defect()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

    
        $defectItems = DB::table('inventories')
            ->join('vendors', 'inventories.id_vendor', '=', 'vendors.id')
            ->where('inventories.status', 'defect')
            ->select('inventories.*', 'vendors.name as vendor_name', 'vendors.contact as vendor_contact', 'vendors.id as vendor_id')
            ->get();
    
        $vendors = Vendor::all();
    
        return view('kelolaBarang.defect', compact('defectItems', 'vendors', 'user'));
    }
    
    public function updateDefect(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $barang = DB::table('inventories')->where('id', $id)->first();
    
        if (!$barang) {
            return redirect()->route('barangs.defect')->with('error', 'Barang tidak ditemukan.');
        }
    
        $status = $request->input('status', $barang->status);
    
        DB::table('inventories')->where('id', $id)->update([
            'name' => $request->input('name', $barang->name),
            'identifier' => $request->input('identifier', $barang->identifier),
            'description' => $request->input('description', $barang->description),
            'status' => $status,
            'id_vendor' => $request->input('id_vendor', $barang->id_vendor),
        ]);
    
        return redirect()->route('barangs.defect')->with('success', 'Barang berhasil diupdate!');
    }
    
    
    
}
