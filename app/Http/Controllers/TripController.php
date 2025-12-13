<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->where('user_id', request()->user()->id)
            ->with(['listing', 'listing.photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->paginate(10);

        return view('trips.index', compact('bookings'));
    }
}
