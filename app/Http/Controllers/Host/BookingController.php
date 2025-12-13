<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->whereHas('listing', fn ($q) => $q->where('user_id', request()->user()->id))
            ->with([
                'guest',
                'listing',
                'listing.photos' => fn ($q) => $q->where('is_cover', true),
            ])
            ->latest()
            ->paginate(15);

        return view('host.bookings.index', compact('bookings'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        // host can cancel only bookings for their own listings
        abort_unless($booking->listing && $booking->listing->user_id === request()->user()->id, 403);

        if (! in_array($booking->status, ['pending', 'confirmed'], true)) {
            return back()->with('status', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('status', 'Booking cancelled.');
    }
}
