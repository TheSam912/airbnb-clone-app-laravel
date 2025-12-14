<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $listings = request()->user()
            ->wishlistListings()
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('listings'));
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
