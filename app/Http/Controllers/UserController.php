<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserController extends Controller
{

    public function rules($id = false)
    {
        return  [
            'name' => 'required',
        ];
    }

    public function index()
    {
        $user = User::simplepaginate(10);
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'nomor' => 'required',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'role' => $request['role'],
            'email' => $request['email'],
            'nomor' => $request['nomor'],
            'password' => bcrypt($request['password']),
        ]);

        return redirect('/user')->with('success', 'Tambah user berhasil.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('status', 'Delete data succesfully.');
    }
}