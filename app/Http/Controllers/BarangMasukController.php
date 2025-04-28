<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Vendor;
use App\Models\User; // Pastikan model User sudah ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        // Menyusun query untuk menampilkan barang dan nama vendor terkait
        $query = DB::table('inventories')
            ->join('vendors', 'inventories.id_vendor', '=', 'vendors.id')
            ->select('inventories.*', 'vendors.name as vendor_name');

        // Jika ada pencarian, menambahkan filter berdasarkan nama barang
        if ($request->filled('search')) {
            $query->where('inventories.name', 'like', '%' . $request->search . '%');
        }

        // Mendapatkan data barang
        $barangs = $query->get();

        return view('BarangMasuk.index', compact('barangs'));
    }

    public function create()
    {
        $vendors = Vendor::all();  // Mengambil data vendor
        $users = User::all();      // Mendapatkan data pengguna
        return view('BarangMasuk.create', compact('vendors', 'users'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        // Validasi input untuk memastikan data yang dikirim lengkap
        $request->validate([
            'barang.*.name' => 'required|string|max:255',
            'barang.*.identifier' => 'required|string',
            'barang.*.vendor' => 'required|exists:vendors,id',
        ]);

        $barangData = $request->input('barang');

        foreach ($barangData as $data) {
            Inventory::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'identifier' => $data['identifier'],
                'id_vendor' => $data['vendor'],
                'created_with' => auth()->user()->name,  // Simpan nama pengguna yang menambah barang
                // 'user_id' => auth()->id(),  // Menyimpan ID pengguna yang menambahkan barang
            ]);
        }

        return redirect('/barangs')->with('success', 'Semua barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Menampilkan detail barang dan vendor terkait
        $barang = Inventory::with('vendor')->findOrFail($id);
        return view('BarangMasuk.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Inventory::findOrFail($id);
        $vendors = Vendor::all();  // Mendapatkan data vendor
        return view('BarangMasuk.edit', compact('barang', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
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
            'updated_with' => auth()->user()->name,  // Simpan nama pengguna yang mengupdate barang
            // 'user_i' => auth()->id(), // Menyimpan ID pengguna yang mengupdate barang
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
