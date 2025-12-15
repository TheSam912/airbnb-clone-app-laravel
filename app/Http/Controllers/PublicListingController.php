<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicListingController extends Controller
{
    public function index(Request $request): View
    {
        $q = Listing::query()
            ->where('is_published', true);

        // filters (optional)
        if ($request->filled('where')) {
            $where = trim($request->string('where'));
            $q->where(fn ($qq) => $qq->where('city', 'like', "%{$where}%")
                ->orWhere('country', 'like', "%{$where}%")
            );
        }

        if ($request->filled('guests')) {
            $q->where('max_guests', '>=', (int) $request->guests);
        }

        $amenities = Amenity::orderBy('name')->get();

        $listings = (clone $q)
            ->select(['id', 'title', 'city', 'country', 'price_per_night', 'currency', 'lat', 'lng'])
            ->with(['photos' => fn ($photos) => $photos->where('is_cover', true)])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $mapListings = (clone $q)
            ->select(['id', 'title', 'city', 'country', 'price_per_night', 'currency', 'lat', 'lng'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->limit(200)
            ->get();

        $wishlistedIds = $request->user()
    ? $request->user()->wishlistListings()->pluck('listings.id')->all()
    : [];

        return view('listings.index', compact('listings', 'amenities', 'mapListings', 'wishlistedIds'));
    }

    public function show(Listing $listing): View
    {
        abort_unless($listing->is_published, 404);

        $listing->load([
            'photos' => fn ($q) => $q->orderByDesc('is_cover')->orderBy('sort_order'),
            'amenities',
        ]);

        return view('listings.show', compact('listing'));
    }
}
