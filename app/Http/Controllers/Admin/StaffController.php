<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    // 1. Tampilkan Daftar Staff (Kurir & Groomer)
    public function index()
    {
        $staffs = User::whereIn('role', ['courier', 'groomer'])
            ->latest()
            ->get();

        return view('admin.staff.index', compact('staffs'));
    }

    // 2. Tampilkan Form Tambah Staff
    public function create()
    {
        return view('admin.staff.create');
    }

    // 3. Proses Simpan Staff Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'role' => ['required', 'in:courier,groomer'], // Hanya boleh 2 ini
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Akun Staff berhasil dibuat!');
    }

    // 4. Hapus Staff
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: Jangan sampai menghapus Admin atau User biasa lewat menu ini
        if (!in_array($user->role, ['courier', 'groomer'])) {
            return back()->with('error', 'Hanya akun staff yang boleh dihapus dari sini.');
        }

        $user->delete();

        return back()->with('success', 'Data staff berhasil dihapus.');
    }
}
