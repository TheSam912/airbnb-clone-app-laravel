<x-host.wizard-layout :step="$step">
    <h3 class="text-lg font-semibold text-gray-900">Pricing & publish</h3>
    <p class="text-sm text-gray-500 mt-1">Set your nightly price and publish when ready.</p>

    <form method="POST" action="{{ route('host.onboarding.listings.store', [$listing, 5]) }}" class="mt-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-1">
                <label class="block text-sm font-medium mb-1">Currency</label>
                <select name="currency"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                    @php $cur = old('currency', $listing->currency); @endphp
                    @foreach(['GBP', 'EUR', 'USD'] as $c)
                        <option value="{{ $c }}" @selected($cur === $c)>{{ $c }}</option>
                    @endforeach
                </select>
                @error('currency') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-medium mb-1">Price per night</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">
                        {{ old('currency', $listing->currency) }}
                    </span>
                    <input type="number" step="1" min="10" max="5000" name="price_per_night"
                        value="{{ old('price_per_night', number_format($listing->price_per_night / 100, 2, '.', '')) }}"
                        class="w-full pl-14 rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="129">
                </div>
                <p class="text-xs text-gray-500 mt-1">We store price in cents in the database.</p>
                @error('price_per_night') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="border rounded-2xl p-4 bg-gray-50">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" name="is_published" value="1"
                    class="mt-1 rounded border-gray-300 text-red-600 focus:ring-red-500" @checked(old('is_published', $listing->is_published))>
                <div>
                    <div class="font-medium text-gray-900">Publish this listing</div>
                    <div class="text-sm text-gray-600">
                        Publishing will make your listing visible to guests.
                    </div>
                </div>
            </label>
        </div>

        {{-- Quick checklist (nice UX) --}}
        <div class="text-sm text-gray-700 space-y-2">
            <div class="font-medium text-gray-900">Checklist</div>
            <div class="flex items-center justify-between border rounded-xl p-3">
                <span>Title</span>
                <span class="{{ $listing->title ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ $listing->title ? 'Done' : 'Missing' }}
                </span>
            </div>
            <div class="flex items-center justify-between border rounded-xl p-3">
                <span>Location</span>
                <span
                    class="{{ $listing->city && $listing->country && $listing->address_line1 ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ $listing->city && $listing->country && $listing->address_line1 ? 'Done' : 'Missing' }}
                </span>
            </div>
            <div class="flex items-center justify-between border rounded-xl p-3">
                <span>Photos</span>
                <span class="{{ $listing->photos->count() ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ $listing->photos->count() ? 'Done' : 'Missing' }}
                </span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('host.onboarding.listings.show', [$listing, 4]) }}"
                class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                Back
            </a>

            <button class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Finish
            </button>
        </div>
    </form>
</x-host.wizard-layout>