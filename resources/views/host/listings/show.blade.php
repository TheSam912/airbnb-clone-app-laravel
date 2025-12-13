<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $listing->title }}</h2>
            <a class="underline" href="{{ route('host.listings.edit', $listing) }}">Edit</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow rounded p-6 space-y-3">
                <div class="text-gray-700">{{ $listing->description }}</div>

                <div class="text-sm text-gray-600">
                    {{ $listing->address_line1 }}
                    @if($listing->address_line2), {{ $listing->address_line2 }} @endif
                    — {{ $listing->city }}, {{ $listing->country }}
                </div>

                <div class="text-sm">
                    <span class="font-medium">Price:</span>
                    {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }} / night
                </div>

                <div class="text-sm">
                    <span class="font-medium">Capacity:</span>
                    {{ $listing->max_guests }} guests ·
                    {{ $listing->bedrooms }} bedrooms ·
                    {{ $listing->beds }} beds ·
                    {{ $listing->bathrooms }} bathrooms
                </div>

                <div class="text-sm">
                    <span class="font-medium">Amenities:</span>
                    {{ $listing->amenities->pluck('name')->join(', ') ?: 'None' }}
                </div>

                <div class="text-sm">
                    <span class="font-medium">Published:</span>
                    {{ $listing->is_published ? 'Yes' : 'No' }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>