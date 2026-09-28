<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of users with search and filter.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('nomor', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Summary counts
        $totalUsers   = User::count();
        $superUsers   = User::where('role', 'super')->count();
        $laboranUsers = User::where('role', 'like', '%lab%')->count();
        $dosenUsers   = User::where('role', 'dosen')->count();

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $user = $query->orderBy('name')->paginate($perPage)->withQueryString();

        return view('user.index', compact('user', 'totalUsers', 'superUsers', 'laboranUsers', 'dosenUsers'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|string',
            'nomor'    => 'nullable|string|max:50',
        ], [
            'name.required'     => 'Nama pengguna wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar pada akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Peran/Role wajib dipilih.',
        ]);

        User::create([
            'name'     => trim($request->name),
            'email'    => trim(strtolower($request->email)),
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'nomor'    => $request->nomor ? trim($request->nomor) : null,
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role'     => 'required|string',
            'nomor'    => 'nullable|string|max:50',
        ], [
            'name.required'  => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar pada akun lain.',
            'password.min'   => 'Password baru minimal 6 karakter.',
            'role.required'  => 'Peran/Role wajib dipilih.',
        ]);

        $data = [
            'name'  => trim($request->name),
            'email' => trim(strtolower($request->email)),
            'role'  => $request->role,
            'nomor' => $request->nomor ? trim($request->nomor) : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Display the authenticated user's profile (/viewuser).
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor'    => 'nullable|string|max:50',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar pada akun lain.',
            'password.min'       => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $data = [
            'name'  => trim($request->name),
            'email' => trim(strtolower($request->email)),
            'nomor' => $request->nomor ? trim($request->nomor) : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.profile')->with('success', 'Profil akun Anda berhasil diperbarui.');
    }

    /**
     * Display the specified user details.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $isReadOnly = (Auth::id() != $id && Auth::user()->role !== 'super');
        return view('user.profile', compact('user', 'isReadOnly'));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}