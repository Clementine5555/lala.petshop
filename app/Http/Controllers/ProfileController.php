<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $user = $request->user();
        $validated = $request->validated();

        // Handle profile photo deletion
        if ($request->has('delete_profile_photo') && $request->boolean('delete_profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = null;
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new profile photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // Update basic profile information
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // If caller expects JSON (AJAX), return JSON. Otherwise redirect back with flash message
        if ($request->wantsJson() || $request->ajax() || $request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mantap! Profile berhasil diupdate.'
            ]);
        }

        return Redirect::back()->with('success', 'Mantap! Profile berhasil diupdate.');
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
