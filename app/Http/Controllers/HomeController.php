<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $featured = Listing::query()
            ->where('is_published', true)
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->take(6)
            ->get();

        $user = $request->user();

        $wishlistedIds = $user
            ? $user->wishlistListings()->pluck('listings.id')->all()
            : [];

        return view('home', compact('featured', 'wishlistedIds'));
    }
}
