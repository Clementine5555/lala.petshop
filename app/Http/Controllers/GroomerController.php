<?php

namespace App\Http\Controllers;

use App\Models\Groomer;
use App\Models\Appointment_Detail;
use Carbon\Carbon;
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

		// Load today's appointments (appointment details) for dashboard
		$today = Carbon::today()->toDateString();
		$appointments = Appointment_Detail::with(['user','pet','groomer','service'])
			->whereDate('date', $today)
			->orderBy('time')
			->get();

		// If no appointments for today, fallback to upcoming 7 days so dashboard isn't empty
		if ($appointments->isEmpty()) {
			$appointments = Appointment_Detail::with(['user','pet','groomer','service'])
				->whereDate('date', '>=', $today)
				->whereDate('date', '<=', Carbon::today()->addDays(7)->toDateString())
				->orderBy('date')
				->orderBy('time')
				->get();
		}

		// Prepare appointments payload for client-side interaction (JS)
		$appointmentsForJs = $appointments->map(function($d) {
			$rawTime = $d->time ?? null;
			$time = '';
			if ($rawTime) {
				if ($rawTime instanceof \DateTimeInterface) {
					$time = $rawTime->format('h:i A');
				} else {
					try {
						$time = date('h:i A', strtotime($rawTime));
					} catch (\Throwable $e) {
						$time = (string) $rawTime;
					}
				}
			}

			$petWeight = optional($d->pet)->weight;

			return [
				'id' => $d->appointment_detail_id,
				'time' => $time,
				'customer' => optional($d->user)->name ?: optional($d->user)->email ?: 'Guest',
				'payment' => '',
				'petName' => optional($d->pet)->name ?: '-',
				'petType' => optional($d->pet)->type ?: '-',
				'weight' => $petWeight ? ($petWeight . ' kg') : '-',
				'gender' => optional($d->pet)->gender ?: '-',
				'petIcon' => (optional($d->pet)->type && stripos(optional($d->pet)->type, 'dog') !== false) ? '🐕' : '🐱',
				'service' => optional($d->service)->name ?: '-',
				'notes' => $d->note ?: '',
				'status' => $d->status ?: 'pending',
				'completedAt' => null,
			];
		});

		// compute simple stats to display in the header cards
		$todayCount = $appointments->count();
		$pendingCount = $appointments->where('status', 'pending')->count();
		$inprogressCount = $appointments->where('status', 'inprogress')->count();
		$completedCount = $appointments->where('status', 'completed')->count();

		// Note: views are located under resources/views/groomer (singular)
		return view('groomer.index', compact('groomers','appointments','appointmentsForJs','todayCount','pendingCount','inprogressCount','completedCount'));
	}

	/**
	 * Show the form for creating a new groomer.
	 */
	public function create()
	{
		$this->authorizeAdmin();
		return view('groomer.create');
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
		return view('groomer.show', compact('groomer'));
	}

	/**
	 * Show the form for editing the specified groomer.
	 */
	public function edit(Groomer $groomer)
	{
		$this->authorizeAdmin();
		return view('groomer.edit', compact('groomer'));
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
