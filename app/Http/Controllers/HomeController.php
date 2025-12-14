<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Listing::query()
            ->where('is_published', true)
            ->with(['photos' => fn ($q) => $q->where('is_cover', true)])
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featured'));
    }
}
