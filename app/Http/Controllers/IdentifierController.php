<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IdentifierController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:255|unique:identifiers,identifier',
            'quantity' => 'required|integer|min:0',
        ]);

        DB::table('identifiers')->insert([
            'identifier' => $request->identifier,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Identifier berhasil ditambahkan!');
    }

    public function update(Request $request, $identifier)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        DB::table('identifiers')
            ->where('identifier', $identifier)
            ->update([
                'quantity' => $request->quantity,
            ]);

        return redirect()->back()->with('success', 'Identifier berhasil diperbarui.');
    }

    public function destroy($identifier)
    {
        DB::table('identifiers')->where('identifier', $identifier)->delete();
        return redirect()->back()->with('success', 'Identifier berhasil dihapus.');
    }

}
