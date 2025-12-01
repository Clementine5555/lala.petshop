<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the authenticated user's pets.
     */
    public function index()
    {
        $pets = Pet::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'race' => 'nullable|string|max:100',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'gender' => 'nullable|in:male,female',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $data['user_id'] = Auth::id();

        Pet::create($data);

        return redirect()->route('pets.index')->with('success', 'Pet added successfully.');
    }

    /**
     * Display the specified pet.
     */
    public function show(Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit(Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pets.edit', compact('pet'));
    }

    /**
     * Update the specified pet in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'race' => 'nullable|string|max:100',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'gender' => 'nullable|in:male,female',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                Storage::disk('public')->delete($pet->photo);
            }
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('pets.show', $pet)->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified pet from storage.
     */
    public function destroy(Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        if ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
            Storage::disk('public')->delete($pet->photo);
        }

        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
    }
}
