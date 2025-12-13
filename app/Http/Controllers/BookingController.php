<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, Listing $listing): RedirectResponse
    {
        abort_unless($listing->is_published, 404);

        $data = $request->validated();

        // basic guests check
        if ((int) $data['guests'] > (int) $listing->max_guests) {
            return back()->withErrors(['guests' => 'Guest count exceeds maximum allowed.'])->withInput();
        }

        $checkIn = Carbon::parse($data['check_in'])->startOfDay();
        $checkOut = Carbon::parse($data['check_out'])->startOfDay();

        // Overlap rule: existing.check_in < requested.check_out AND existing.check_out > requested.check_in
        $overlap = Booking::query()
            ->where('listing_id', $listing->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOut->toDateString())
            ->where('check_out', '>', $checkIn->toDateString())
            ->exists();

        if ($overlap) {
            return back()->withErrors(['check_in' => 'Those dates are not available.'])->withInput();
        }

        $nights = $checkIn->diffInDays($checkOut);
        $pricePerNight = (int) $listing->price_per_night;
        $subtotal = $nights * $pricePerNight;

        Booking::create([
            'listing_id' => $listing->id,
            'user_id' => $request->user()->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'guests' => (int) $data['guests'],
            'price_per_night' => $pricePerNight,
            'subtotal' => $subtotal,
            'status' => 'confirmed', // keep it simple for now
        ]);

        return redirect()->route('trips.index')->with('status', 'Booking confirmed.');
    }
}
