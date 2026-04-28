<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public function index()
    {
        $labo = Laboratorium::all();
        return view('labo.index', compact('labo'));
    }

    public function create()
    {
        return view('labo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'laboratorium' => 'required|string|max:255',
        ]);

        Laboratorium::create(['laboratorium' => $request->laboratorium]);

        return redirect()->route('laboratorium.index')->with('success', 'Laboratorium created successfully!');
    }

    public function edit($id)
    {
        $labo = Laboratorium::findOrFail($id);
        return view('labo.edit', compact('labo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'laboratorium' => 'required|string|max:255',
        ]);

        $labo = Laboratorium::findOrFail($id);
        $labo->update(['laboratorium' => $request->laboratorium]);

        return redirect()->route('labo.index')->with('success', 'Laboratorium updated successfully!');
    }

    public function destroy($id)
    {
        $labo = Laboratorium::findOrFail($id);
        $labo->delete();

        return redirect()->route('labo.index')->with('success', 'Laboratorium deleted successfully!');
    }
}