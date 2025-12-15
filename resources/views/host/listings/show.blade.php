<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $listing->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $listing->city }}, {{ strtoupper($listing->country) }}
                    <span class="text-gray-300 mx-2">•</span>
                    {{ $listing->is_published ? 'Published' : 'Draft' }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a class="px-4 py-2 rounded-lg border hover:bg-gray-50"
                    href="{{ route('host.listings.index') }}">Back</a>
                <a class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black"
                    href="{{ route('host.listings.edit', $listing) }}">Edit</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Photos --}}
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                @if($listing->photos->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
                        @foreach($listing->photos as $photo)
                            <div class="bg-gray-100">
                                <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-60 object-cover" alt="">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        No photos uploaded yet.
                        <a class="underline ml-1" href="{{ route('host.listings.edit', $listing) }}">Upload photos</a>
                    </div>
                @endif
            </div>

            {{-- Info cards --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border rounded-xl shadow-sm p-6 space-y-4">
                    <div>
                        <div class="text-sm font-medium text-gray-900">Description</div>
                        <p class="text-gray-700 whitespace-pre-line mt-1">{{ $listing->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div class="p-3 rounded-lg border bg-gray-50">
                            <div class="text-gray-500">Guests</div>
                            <div class="font-semibold text-gray-900">{{ $listing->max_guests }}</div>
                        </div>
                        <div class="p-3 rounded-lg border bg-gray-50">
                            <div class="text-gray-500">Bedrooms</div>
                            <div class="font-semibold text-gray-900">{{ $listing->bedrooms }}</div>
                        </div>
                        <div class="p-3 rounded-lg border bg-gray-50">
                            <div class="text-gray-500">Beds</div>
                            <div class="font-semibold text-gray-900">{{ $listing->beds }}</div>
                        </div>
                        <div class="p-3 rounded-lg border bg-gray-50">
                            <div class="text-gray-500">Bathrooms</div>
                            <div class="font-semibold text-gray-900">{{ $listing->bathrooms }}</div>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm font-medium text-gray-900">Amenities</div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @forelse($listing->amenities as $amenity)
                                <span class="text-xs px-2 py-1 rounded-full border bg-gray-50">
                                    {{ $amenity->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">No amenities selected.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white border rounded-xl shadow-sm p-6 space-y-4 h-fit">
                    <div>
                        <div class="text-sm text-gray-500">Price</div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
                            <span class="text-sm font-normal text-gray-500">/ night</span>
                        </div>
                    </div>

                    <div class="text-sm text-gray-700">
                        <div class="font-medium text-gray-900 mb-1">Address</div>
                        <div>{{ $listing->address_line1 }}</div>
                        @if($listing->address_line2)
                        <div>{{ $listing->address_line2 }}</div> @endif
                        <div>{{ $listing->city }} {{ $listing->postcode }}</div>
                        <div>{{ strtoupper($listing->country) }}</div>
                    </div>

                    <div class="pt-2 border-t text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Status</span>
                            <span
                                class="font-medium {{ $listing->is_published ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $listing->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-gray-500">Updated</span>
                            <span class="font-medium text-gray-900">{{ $listing->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <a href="{{ route('host.listings.edit', $listing) }}"
                        class="inline-flex justify-center w-full px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black">
                        Edit listing
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>