<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $listings = $user->wishlistListings()
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->paginate(12);

        $wishlistedIds = $user->wishlistListings()->pluck('listings.id')->all();

        return view('wishlist.index', compact('listings', 'wishlistedIds'));
    }

    public function store(Listing $listing): RedirectResponse
    {
        request()->user()->wishlistListings()->syncWithoutDetaching($listing->id);

        return back();
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        request()->user()->wishlistListings()->detach($listing->id);

        return back();
    }
}
