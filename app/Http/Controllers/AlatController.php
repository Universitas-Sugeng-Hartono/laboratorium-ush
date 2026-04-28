<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::all();
        return view('alat.index', compact('alat'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alat' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|string|max:255',
        ]);

        Alat::create([
            'alat' => $request->alat,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat created successfully!');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alat' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|string|max:255',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update([
            'alat' => $request->alat,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat updated successfully!');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat deleted successfully!');
    }
}