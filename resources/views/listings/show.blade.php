<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $listing->title }}</h1>
                <div class="text-sm text-gray-600 mt-1">
                    {{ $listing->city }}, {{ strtoupper($listing->country) }}
                    <span class="text-gray-300 mx-2">•</span>
                    Hosted by {{ $listing->host->name }}
                </div>
            </div>

            {{-- Photo grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($listing->photos as $photo)
                    <div class="bg-gray-100 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-56 object-cover" alt="">
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white border rounded-xl p-6 space-y-4">
                    <div class="text-gray-700 whitespace-pre-line">{{ $listing->description }}</div>

                    <div class="text-sm text-gray-700">
                        <span class="font-medium">Capacity:</span>
                        {{ $listing->max_guests }} guests ·
                        {{ $listing->bedrooms }} bedrooms ·
                        {{ $listing->beds }} beds ·
                        {{ $listing->bathrooms }} bathrooms
                    </div>

                    <div>
                        <div class="font-medium text-gray-900 mb-2">Amenities</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($listing->amenities as $amenity)
                                <span class="text-xs px-2 py-1 rounded-full border bg-gray-50">
                                    {{ $amenity->name }}
                                </span>
                            @endforeach
                            @if($listing->amenities->isEmpty())
                                <span class="text-sm text-gray-500">No amenities listed.</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Price card (booking UI comes next) --}}
                <div class="bg-white border rounded-xl p-6 space-y-3 h-fit">
                    <div class="text-xl font-bold">
                        {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
                        <span class="text-sm font-normal text-gray-500">/ night</span>
                    </div>

                    <div class="text-sm text-gray-500">
                        Booking flow next (dates, guests, availability check).
                    </div>

                    <a href="{{ route('listings.index') }}"
                        class="inline-flex justify-center w-full px-4 py-2 rounded-lg border hover:bg-gray-50">
                        Back to listings
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>