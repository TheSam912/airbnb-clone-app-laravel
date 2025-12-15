<?php

namespace App\Http\Controllers\Host\Onboarding;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingWizardController extends Controller
{
    public function start(Request $request): RedirectResponse
    {
        $listing = Listing::create([
            'user_id' => $request->user()->id,
            'title' => '',
            'description' => 'Draft listing — add details in the next steps.',

            // Required location fields (draft placeholders)
            'country' => '',
            'city' => '',
            'address_line1' => '',
            'address_line2' => null,
            'postcode' => '',

            'currency' => '',
            'price_per_night' => 10000,
            'max_guests' => 1,
            'bedrooms' => 0,
            'beds' => 1,
            'bathrooms' => 1,
            'is_published' => false,
        ]);

        return redirect()->route('host.onboarding.listings.show', [$listing, 1]);
    }

    public function show(Request $request, Listing $listing, int $step): View
    {
        $this->ensureOwner($request, $listing);

        abort_unless(in_array($step, [1, 2, 3, 4, 5], true), 404);

        $amenities = $step === 3 ? Amenity::query()->orderBy('name')->get() : collect();

        $listing->load(['amenities', 'photos']);

        return view("host.onboarding.steps.step{$step}", compact('listing', 'step', 'amenities'));
    }

    public function store(Request $request, Listing $listing, int $step): RedirectResponse
    {
        $this->ensureOwner($request, $listing);

        abort_unless(in_array($step, [1, 2, 3, 4, 5], true), 404);

        if ($step === 1) {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:80'],
                'max_guests' => ['required', 'integer', 'min:1', 'max:16'],
                'bedrooms' => ['required', 'integer', 'min:0', 'max:20'],
                'beds' => ['required', 'integer', 'min:1', 'max:30'],
                'bathrooms' => ['required', 'numeric', 'min:0.5', 'max:20'],
            ]);

            $listing->update($data);

            return redirect()->route('host.onboarding.listings.show', [$listing, 2]);
        }

        if ($step === 2) {
            $data = $request->validate([
                'country' => ['required', 'string', 'size:2'],
                'city' => ['required', 'string', 'max:80'],
                'address_line1' => ['required', 'string', 'max:120'],
                'address_line2' => ['nullable', 'string', 'max:120'],
                'postcode' => ['required', 'string', 'max:20'],
            ]);

            $listing->update($data);

            return redirect()->route('host.onboarding.listings.show', [$listing, 3]);
        }

        if ($step === 3) {
            $data = $request->validate([
                'amenities' => ['array'],
                'amenities.*' => ['integer', 'exists:amenities,id'],
            ]);

            $listing->amenities()->sync($data['amenities'] ?? []);

            return redirect()->route('host.onboarding.listings.show', [$listing, 4]);
        }

        if ($step === 4) {
            // Photos are handled by your existing photo upload routes on the step page.
            return redirect()->route('host.onboarding.listings.show', [$listing, 5]);
        }

        // Step 5: pricing + publish
        $data = $request->validate([
            'currency' => ['required', 'string', 'size:3'],
            'price_per_night' => ['required', 'numeric', 'min:10', 'max:5000'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $listing->update([
            'currency' => strtoupper($data['currency']),
            'price_per_night' => (int) round($data['price_per_night'] * 100),
            'is_published' => (bool) ($data['is_published'] ?? false),
        ]);

        return redirect()->route('host.listings.edit', $listing)->with('status', 'Listing saved.');
    }

    private function ensureOwner(Request $request, Listing $listing): void
    {
        abort_unless($listing->user_id === $request->user()->id, 403);
    }
}
