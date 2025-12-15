<x-host.wizard-layout :step="$step">
    <h3 class="text-lg font-semibold text-gray-900">Amenities</h3>
    <p class="text-sm text-gray-500 mt-1">Select what your place offers.</p>

    <form method="POST" action="{{ route('host.onboarding.listings.store', [$listing, 3]) }}" class="mt-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($amenities as $amenity)
                <label class="flex items-center gap-3 p-3 rounded-xl border hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500" @checked(in_array($amenity->id, old('amenities', $listing->amenities->pluck('id')->all())))>
                    <span class="text-sm font-medium text-gray-900">{{ $amenity->name }}</span>
                </label>
            @endforeach
        </div>

        @error('amenities') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        @error('amenities.*') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('host.onboarding.listings.show', [$listing, 2]) }}"
                class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                Back
            </a>

            <button class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Next
            </button>
        </div>
    </form>
</x-host.wizard-layout>