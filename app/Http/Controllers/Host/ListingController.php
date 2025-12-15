<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Amenity;
use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(): View
    {
        $listings = Listing::query()
            ->where('user_id', request()->user()->id)
            ->latest()
            ->paginate(10);

        return view('host.listings.index', compact('listings'));
    }

    public function create(): View
    {
        $amenities = Amenity::query()->orderBy('name')->get();

        return view('host.onboarding.listings.start', compact('amenities'));
    }

    public function store(StoreListingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $listing = Listing::create([
            ...collect($data)->except(['amenities'])->all(),
            'user_id' => $request->user()->id,
        ]);

        $listing->amenities()->sync($data['amenities'] ?? []);

        return redirect()
            ->route('host.listings.edit', $listing)
            ->with('status', 'Listing created.');
    }

    public function show(Listing $listing): View
    {
        $this->ensureOwner($listing);

        $listing->load([
            'amenities',
            'photos' => fn ($q) => $q->orderByDesc('is_cover')->orderBy('sort_order'),
        ]);

        return view('host.listings.show', compact('listing'));
    }

    public function edit(Listing $listing): View
    {
        $this->ensureOwner($listing);

        $amenities = Amenity::query()->orderBy('name')->get();
        $listing->load(['amenities', 'photos']);

        return view('host.listings.edit', compact('listing', 'amenities'));
    }

    public function update(UpdateListingRequest $request, Listing $listing): RedirectResponse
    {
        $this->ensureOwner($listing);

        $data = $request->validated();

        $listing->update(collect($data)->except(['amenities'])->all());
        $listing->amenities()->sync($data['amenities'] ?? []);

        return back()->with('status', 'Listing updated.');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $this->ensureOwner($listing);

        $listing->delete();

        return redirect()
            ->route('host.listings.index')
            ->with('status', 'Listing deleted.');
    }

    private function ensureOwner(Listing $listing): void
    {
        abort_unless($listing->user_id === request()->user()->id, 403);
    }

    public function storePhoto(Request $request, Listing $listing): RedirectResponse
    {
        $this->ensureOwner($listing);

        $validated = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB
            'caption' => ['nullable', 'string', 'max:120'],
        ]);

        $path = $request->file('photo')->store('listings/'.$listing->id, 'public');

        $nextOrder = (int) $listing->photos()->max('sort_order');
        $photo = $listing->photos()->create([
            'path' => $path,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $nextOrder + 1,
            'is_cover' => $listing->photos()->count() === 0, // first photo becomes cover
        ]);

        if ($photo->is_cover) {
            $listing->photos()->where('id', '!=', $photo->id)->update(['is_cover' => false]);
        }

        return back()->with('status', 'Photo uploaded.');
    }

    public function destroyPhoto(Listing $listing, ListingPhoto $photo): RedirectResponse
    {
        $this->ensureOwner($listing);
        abort_unless($photo->listing_id === $listing->id, 404);

        Storage::disk('public')->delete($photo->path);
        $wasCover = $photo->is_cover;

        $photo->delete();

        if ($wasCover) {
            $newCover = $listing->photos()->orderBy('sort_order')->first();
            if ($newCover) {
                $listing->photos()->update(['is_cover' => false]);
                $newCover->update(['is_cover' => true]);
            }
        }

        return back()->with('status', 'Photo deleted.');
    }

    public function setCoverPhoto(Listing $listing, ListingPhoto $photo): RedirectResponse
    {
        $this->ensureOwner($listing);
        abort_unless($photo->listing_id === $listing->id, 404);

        $listing->photos()->update(['is_cover' => false]);
        $photo->update(['is_cover' => true]);

        return back()->with('status', 'Cover photo updated.');
    }
}
