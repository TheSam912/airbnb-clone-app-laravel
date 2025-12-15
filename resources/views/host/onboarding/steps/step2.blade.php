<x-host.wizard-layout :step="$step">
    <h3 class="text-lg font-semibold text-gray-900">Location</h3>
    <p class="text-sm text-gray-500 mt-1">Where is your place located?</p>

    <form method="POST" action="{{ route('host.onboarding.listings.store', [$listing, 2]) }}" class="mt-6 space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Country (2-letter)</label>
                <input name="country" value="{{ old('country', $listing->country) }}" placeholder="GB"
                    class="w-full uppercase rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                @error('country') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">City</label>
                <input name="city" value="{{ old('city', $listing->city) }}" placeholder="London"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                @error('city') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address line 1</label>
            <input name="address_line1" value="{{ old('address_line1', $listing->address_line1) }}"
                placeholder="Street + number"
                class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            @error('address_line1') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address line 2 (optional)</label>
            <input name="address_line2" value="{{ old('address_line2', $listing->address_line2) }}"
                placeholder="Apartment, floor, unit"
                class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            @error('address_line2') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Postcode</label>
            <input name="postcode" value="{{ old('postcode', $listing->postcode) }}" placeholder="e.g. N7 9GX"
                class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            @error('postcode') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('host.onboarding.listings.show', [$listing, 1]) }}"
                class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                Back
            </a>

            <button class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Next
            </button>
        </div>
    </form>
</x-host.wizard-layout>