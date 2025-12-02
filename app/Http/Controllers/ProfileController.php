<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
   // menampilkan form edit profil user
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * user dapat memperbarui profilnya
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // RETURN JSON (WAJIB BIAR GAK RELOAD)
        return response()->json([
            'status' => 'success',
            'message' => 'Mantap! Profile berhasil diupdate.'
        ]);
    }

    /**
     * hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Update Nama Lengkap (Full Name)
     
    public function fullNameUpdate(Request $request): RedirectResponse
    {
        // 1. Validasi dulu biar inputnya gak kosong/sembarangan
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update([
            'name' => $validated['name'],
        ]);

        // 3. Balikin user ke halaman sebelumnya (redirect)
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}
