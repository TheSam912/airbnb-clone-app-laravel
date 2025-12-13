<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function show(Request $request, Listing $listing)
    {
        if (! $listing->is_published) {
            return response()->json(['available' => false, 'reason' => 'not_published'], 404);
        }

        $data = $request->validate([
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['nullable', 'integer', 'min:1'],
        ]);

        $guests = (int) ($data['guests'] ?? 1);
        if ($guests > (int) $listing->max_guests) {
            return response()->json(['available' => false, 'reason' => 'too_many_guests']);
        }

        $checkIn = Carbon::parse($data['check_in'])->startOfDay();
        $checkOut = Carbon::parse($data['check_out'])->startOfDay();

        $overlap = Booking::query()
            ->where('listing_id', $listing->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOut->toDateString())
            ->where('check_out', '>', $checkIn->toDateString())
            ->exists();

        if ($overlap) {
            return response()->json(['available' => false, 'reason' => 'overlap']);
        }

        return response()->json(['available' => true]);
    }
}
