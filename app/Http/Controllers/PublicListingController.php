<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicListingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Listing::query()
            ->where('is_published', true)
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)]);

        // City search
        if ($request->filled('city')) {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        // Guests
        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', (int) $request->guests);
        }

        // Price range (in cents)
        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', (int) $request->min_price * 100);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', (int) $request->max_price * 100);
        }

        $listings = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $user = $request->user();

        $wishlistedIds = $user
            ? $user->wishlistListings()->pluck('listings.id')->all()
            : [];

        return view('listings.index', compact('listings', 'wishlistedIds'));
    }

    public function show(Listing $listing): View
    {
        abort_unless($listing->is_published, 404);

        $listing->load([
            'amenities',
            'photos' => fn ($q) => $q->orderByDesc('is_cover')->orderBy('sort_order'),
            'host',
        ]);

        return view('listings.show', compact('listing'));
    }
}
