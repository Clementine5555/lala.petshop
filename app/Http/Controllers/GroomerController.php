<?php

namespace App\Http\Controllers;

use App\Models\Groomer;
use Illuminate\Http\Request;

class GroomerController extends Controller
{
	public function __construct()
	{
		// Apply auth middleware for all routes in this controller
		$this->middleware('auth');
	}

	/**
	 * Display a listing of groomers.
	 */
	public function index(Request $request)
	{
		$query = Groomer::query();

		if ($request->filled('search')) {
			$s = $request->search;
			$query->where('name', 'like', "%{$s}%")
				  ->orWhere('email', 'like', "%{$s}%")
				  ->orWhere('address', 'like', "%{$s}%");
		}

		$groomers = $query->orderBy('name')->paginate(12);

		return view('groomers.index', compact('groomers'));
	}

	/**
	 * Show the form for creating a new groomer.
	 */
	public function create()
	{
		$this->authorizeAdmin();
		return view('groomers.create');
	}

	/**
	 * Store a newly created groomer in storage.
	 */
	public function store(Request $request)
	{
		$this->authorizeAdmin();

		$data = $request->validate([
			'name' => 'required|string|max:191',
			'email' => 'nullable|email|max:191',
			'phone_number' => 'nullable|string|max:30',
			'address' => 'nullable|string',
			'total_appointments_completed' => 'nullable|integer|min:0',
			'total_hours_worked' => 'nullable|integer|min:0',
		]);

		Groomer::create($data);

		return redirect()->route('groomers.index')->with('success', 'Groomer created successfully.');
	}

	/**
	 * Display the specified groomer.
	 */
	public function show(Groomer $groomer)
	{
		return view('groomers.show', compact('groomer'));
	}

	/**
	 * Show the form for editing the specified groomer.
	 */
	public function edit(Groomer $groomer)
	{
		$this->authorizeAdmin();
		return view('groomers.edit', compact('groomer'));
	}

	/**
	 * Update the specified groomer in storage.
	 */
	public function update(Request $request, Groomer $groomer)
	{
		$this->authorizeAdmin();

		$data = $request->validate([
			'name' => 'required|string|max:191',
			'email' => 'nullable|email|max:191',
			'phone_number' => 'nullable|string|max:30',
			'address' => 'nullable|string',
			'total_appointments_completed' => 'nullable|integer|min:0',
			'total_hours_worked' => 'nullable|integer|min:0',
		]);

		$groomer->update($data);

		return redirect()->route('groomers.index')->with('success', 'Groomer updated successfully.');
	}

	/**
	 * Remove the specified groomer from storage.
	 */
	public function destroy(Groomer $groomer)
	{
		$this->authorizeAdmin();

		$groomer->delete();

		return redirect()->route('groomers.index')->with('success', 'Groomer deleted successfully.');
	}

	/**
	 * Helper: only allow admin/superadmin
	 */
	protected function authorizeAdmin()
	{
		$user = auth()->user();
		if (! $user || ! in_array($user->role, ['admin','superadmin'])) {
			abort(403);
		}
	}
}
