<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retur;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class ReturController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        $user = auth()->user();
        $search = $request->input('search');
    
        $returs = Retur::with('vendor')
            ->whereIn('status', ['pending', 'in progress'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->latest()
            ->get();
    
        $vendors = Vendor::select('id', 'name', 'contact')->get();
    
        return view('returs.index', compact('returs', 'vendors', 'search', 'user'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'id_vendor' => 'required|exists:vendors,id',
            'picture_1' => 'nullable|image|max:2048',
            'picture_2' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description', 'id_vendor');
        $data['status'] = 'pending';
        $data['created_with'] = Auth::user()->username;

        if ($request->hasFile('picture_1')) {
            $data['picture_1'] = $request->file('picture_1')->store('returs', 'public');
        }

        if ($request->hasFile('picture_2')) {
            $data['picture_2'] = $request->file('picture_2')->store('returs', 'public');
        }

        Retur::create($data);
        return back()->with('success', 'Retur berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $request->validate([
            'status' => 'required|in:pending,in progress,done'
        ]);

        $retur = Retur::findOrFail($id);
        $retur->status = $request->status;
        $retur->updated_with = Auth::user()->username;
        $retur->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        Retur::destroy($id);
        return back()->with('success', 'Retur berhasil dihapus.');
    }
}
