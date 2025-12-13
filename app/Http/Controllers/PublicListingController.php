<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicListingController extends Controller
{
    public function index(Request $request): View
    {
        $listings = Listing::query()
            ->where('is_published', true)
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->paginate(12);

        return view('listings.index', compact('listings'));
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
