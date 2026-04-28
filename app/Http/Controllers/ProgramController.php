<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('program.index', compact('programs'));
    }

    public function create()
    {
        return view('program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program' => 'required|string|max:255',
        ]);

        Program::create(['program' => $request->program]);

        return redirect()->route('program.index')->with('success', 'Program Studi created successfully!');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program' => 'required|string|max:255',
        ]);

        $program = Program::findOrFail($id);
        $program->update(['program' => $request->program]);

        return redirect()->route('program.index')->with('success', 'Program Studi updated successfully!');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('program.index')->with('success', 'Program Studi deleted successfully!');
    }
}