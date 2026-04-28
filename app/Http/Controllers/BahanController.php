<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        $bahan = Bahan::all();
        return view('bahan.index', compact('bahan'));
    }

    public function create()
    {
        return view('bahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|string|max:255',
            'satuan' => 'nullable|string|max:255',
        ]);

        Bahan::create([
            'bahan' => $request->bahan,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('bahan.index')->with('success', 'Bahan created successfully!');
    }

    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('bahan.edit', compact('bahan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bahan' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|string|max:255',
            'satuan' => 'nullable|string|max:255',
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->update([
            'alat' => $request->alat,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('bahan.index')->with('success', 'Bahan updated successfully!');
    }

    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->route('bahan.index')->with('success', 'Bahan deleted successfully!');
    }
}