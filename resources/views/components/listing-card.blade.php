@props([
    'listing',
    'wishlistedIds' => [],
])

@php
    $cover = $listing->photos->first();
    $saved = auth()->check() && in_array($listing->id, $wishlistedIds);
@endphp

<a href="{{ route('listings.show', $listing) }}"
   class="group block bg-white border rounded-2xl overflow-hidden hover:shadow-sm transition">
    <div class="h-44 bg-gray-100 relative">
        @if($cover)
            <img src="{{ asset('storage/' . $cover->path) }}"
                 class="w-full h-44 object-cover group-hover:scale-[1.02] transition"
                 alt="">
        @endif

        @auth
            <form method="POST"
                  action="{{ $saved ? route('wishlist.destroy', $listing) : route('wishlist.store', $listing) }}"
                  class="absolute top-3 right-3"
                  onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                @csrf
                @if($saved) @method('DELETE') @endif

                <button type="submit"
                        class="relative w-10 h-10 rounded-full bg-black/35 text-white backdrop-blur
                               flex items-center justify-center hover:bg-black/45 transition">
                    <svg viewBox="0 0 32 32" class="w-5 h-5">
                        <path
                            d="M16 28s-9.5-6.2-13.3-11C-0.4 12.9 1.3 7.6 5.4 5.3c3-1.7 6.6-1 8.8 1.3L16 8.5l1.8-1.9c2.2-2.3 5.8-3 8.8-1.3 4.1 2.3 5.8 7.6 2.7 11.7C25.5 21.8 16 28 16 28z"
                            stroke-width="2" stroke-linejoin="round"
                            class="{{ $saved ? 'fill-red-600 stroke-white' : 'fill-none stroke-white' }}"
                        />
                    </svg>
                </button>
            </form>
        @endauth
    </div>

    <div class="p-4 space-y-1">
        <div class="text-sm text-gray-600">
            {{ $listing->city }}, {{ strtoupper($listing->country) }}
        </div>
        <div class="font-semibold text-gray-900 truncate">{{ $listing->title }}</div>
        <div class="text-sm text-gray-700">
            {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
            <span class="text-gray-500">/ night</span>
        </div>
    </div>
</a>