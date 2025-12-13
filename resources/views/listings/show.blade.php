<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $listing->title }}</h1>
                <div class="text-sm text-gray-600 mt-1">
                    {{ $listing->city }}, {{ strtoupper($listing->country) }}
                    <span class="text-gray-300 mx-2">•</span>
                    Hosted by {{ $listing->host->name }}
                </div>
            </div>

            {{-- Photo grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($listing->photos as $photo)
                    <div class="bg-gray-100 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-56 object-cover" alt="">
                    </div>
                @endforeach
            </div>
            <div x-data="gallery({{ $listing->photos->pluck('path')->values()->toJson() }})">
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

                    <div class="bg-white border rounded-xl p-6 space-y-4 h-fit">
                        <div class="text-xl font-bold">
                            {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
                            <span class="text-sm font-normal text-gray-500">/ night</span>
                        </div>

                        @if (session('status'))
                            <div class="p-3 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('bookings.store', $listing) }}" class="space-y-3">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium mb-1">Check-in</label>
                                <input type="date" name="check_in" value="{{ old('check_in') }}"
                                    class="w-full rounded border-gray-300">
                                @error('check_in') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Check-out</label>
                                <input type="date" name="check_out" value="{{ old('check_out') }}"
                                    class="w-full rounded border-gray-300">
                                @error('check_out') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Guests</label>
                                <input type="number" name="guests" min="1" max="{{ $listing->max_guests }}"
                                    value="{{ old('guests', 1) }}" class="w-full rounded border-gray-300">
                                @error('guests') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button class="w-full px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                Reserve
                            </button>

                            <p class="text-xs text-gray-500 text-center">
                                You won’t be charged — payments later.
                            </p>
                        </form>
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