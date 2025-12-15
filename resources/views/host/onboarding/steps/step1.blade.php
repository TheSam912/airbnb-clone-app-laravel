<x-host.wizard-layout :step="$step">
    <h3 class="text-lg font-semibold text-gray-900">Basics</h3>
    <p class="text-sm text-gray-500 mt-1">Give your place a title and set capacity.</p>

    <form method="POST" action="{{ route('host.onboarding.listings.storeStep1') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title" value="{{ old('title') }}" placeholder="e.g. Cozy studio near King’s Cross"
                class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Guests</label>
                <input type="number" name="max_guests" min="1" value="{{ old('max_guests', 1) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Bedrooms</label>
                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', 0) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Beds</label>
                <input type="number" name="beds" min="1" value="{{ old('beds', 1) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Bathrooms</label>
                <input type="number" step="0.5" name="bathrooms" min="0.5" value="{{ old('bathrooms', 1) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
            </div>
        </div>

        <div class="flex justify-end">
            <button class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Next
            </button>
        </div>
    </form>
</x-host.wizard-layout>