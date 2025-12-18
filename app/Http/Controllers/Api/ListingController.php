<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $q = Listing::query()
            ->where('is_published', true)
            ->with([
                'photos' => fn ($p) => $p->orderByDesc('is_cover')->limit(1),
            ]);

        if ($request->filled('where')) {
            $where = trim($request->string('where'));
            $q->where(fn ($qq) => $qq->where('city', 'like', "%{$where}%")
                ->orWhere('country', 'like', "%{$where}%")
            );
        }

        if ($request->filled('guests')) {
            $q->where('max_guests', '>=', (int) $request->guests);
        }

        if ($request->filled('min_price')) {
            $q->where('price_per_night', '>=', (int) round(((float) $request->min_price) * 100));
        }

        if ($request->filled('max_price')) {
            $q->where('price_per_night', '<=', (int) round(((float) $request->max_price) * 100));
        }

        $sort = $request->string('sort', 'newest')->toString();
        if ($sort === 'price_asc') {
            $q->orderBy('price_per_night');
        } elseif ($sort === 'price_desc') {
            $q->orderByDesc('price_per_night');
        } else {
            $q->latest();
        }

        $listings = $q->paginate(12)->withQueryString();

        return ListingResource::collection($listings);
    }

    public function show(Listing $listing)
    {
        abort_unless($listing->is_published, 404);

        $listing->load([
            'host:id,name',
            'amenities:id,name',
            'photos' => fn ($p) => $p->orderByDesc('is_cover')->orderBy('sort_order'),
        ]);

        return new ListingResource($listing);
    }
}
