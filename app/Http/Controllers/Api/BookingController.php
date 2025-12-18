<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;

class BookingController
{
    public function store(Request $request, Listing $listing)
    {
        abort_unless($listing->is_published, 404);

        $data = $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:'.$listing->max_guests],
        ]);

        // availability: no overlap with non-cancelled bookings
        $overlap = Booking::query()
            ->where('listing_id', $listing->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($data) {
                $q->where('check_in', '<', $data['check_out'])
                    ->where('check_out', '>', $data['check_in']);
            })
            ->exists();

        if ($overlap) {
            return response()->json(['message' => 'Dates not available'], 422);
        }

        $nights = (new \Carbon\Carbon($data['check_in']))->diffInDays(new \Carbon\Carbon($data['check_out']));
        $subtotal = $nights * (int) $listing->price_per_night;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'listing_id' => $listing->id,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'guests' => $data['guests'],
            'subtotal' => $subtotal,
            'status' => 'confirmed',
        ]);

        return response()->json([
            'id' => $booking->id,
            'status' => $booking->status,
            'subtotal' => $booking->subtotal,
            'nights' => $nights,
        ], 201);
    }

    public function trips(Request $request)
    {
        $bookings = Booking::query()
            ->where('user_id', $request->user()->id)
            ->with(['listing:id,title,city,country,currency,price_per_night'])
            ->latest()
            ->paginate(10);

        return response()->json($bookings);
    }

    public function cancel(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === $request->user()->id, 403);

        if ($booking->status === 'cancelled') {
            return response()->noContent();
        }

        $booking->update(['status' => 'cancelled']);

        return response()->noContent();
    }
}
