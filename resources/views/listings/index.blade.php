<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stays</h2>
                <p class="text-sm text-gray-500 mt-1">Browse published listings.</p>
            </div>
        </div>
    </x-slot>
    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('listings.index') }}"
                class="mb-6 bg-white border rounded-2xl p-4 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">

                    {{-- City --}}
                    <div class="lg:col-span-4">
                        <label class="block text-xs font-medium text-gray-500 mb-1">City</label>
                        <input type="text" name="city" value="{{ request('city') }}" placeholder="Where are you going?"
                            class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                    </div>

                    {{-- Guests --}}
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Guests</label>
                        <input type="number" name="guests" min="1" value="{{ request('guests') }}"
                            class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                    </div>

                    {{-- Min price --}}
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Min price</label>
                        <input type="number" name="min_price" min="0" value="{{ request('min_price') }}"
                            placeholder="GBP"
                            class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                    </div>

                    {{-- Max price --}}
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Max price</label>
                        <input type="number" name="max_price" min="0" value="{{ request('max_price') }}"
                            placeholder="GBP"
                            class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                    </div>

                    {{-- Actions --}}
                    <div class="lg:col-span-2 flex gap-2">
                        <button class="w-full px-4 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                            Search
                        </button>

                        <a href="{{ route('listings.index') }}"
                            class="w-full px-4 py-3 rounded-xl border text-center hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            @php
                // Map only on desktop (lg+). If user tries ?view=map on mobile, it won’t render.
                $showMap = request('view') === 'map';

                $showMapUrl = request()->fullUrlWithQuery(['view' => 'map']);
                $hideMapUrl = request()->fullUrlWithQuery(['view' => null]); // removes param
            @endphp

            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-600">
                    Showing {{ $listings->count() }} of {{ $listings->total() }}
                </div>

                {{-- Toggle only visible on desktop (lg+) --}}
                <a href="{{ $showMap ? $hideMapUrl : $showMapUrl }}"
                    class="hidden lg:inline-flex px-4 py-2 rounded-xl border hover:bg-gray-50">
                    {{ $showMap ? 'Hide map' : 'Show map' }}
                </a>
            </div>

            <div class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- List --}}
                <div class="{{ $showMap ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 {{ $showMap ? 'lg:grid-cols-2' : 'lg:grid-cols-3' }} gap-6">
                        @foreach($listings as $listing)
                            <x-listing-card :listing="$listing" :wishlisted-ids="$wishlistedIds ?? []" />
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $listings->links() }}
                    </div>
                </div>

                {{-- Map: only render when showMap AND only show on lg+ --}}
                @if($showMap)
                    <div class="hidden lg:block lg:col-span-5">
                        <div class="sticky top-24">
                            <div class="bg-white border rounded-2xl overflow-hidden">
                                @if($mapListings->isEmpty())
                                    <div class="p-6 text-sm text-gray-600">
                                        No listings have coordinates yet. Add lat/lng to at least one listing to see the map.
                                    </div>
                                @else
                                    <div id="map" style="height:70vh; width:100%;"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const showMap = @js($showMap);
            if (!showMap) return;

            const listings = @js($mapListings->map(fn($l) => [
                'id' => $l->id,
                'title' => $l->title,
                'city' => $l->city,
                'country' => $l->country,
                'currency' => $l->currency,
                'price' => number_format($l->price_per_night / 100, 2, '.', ''),
                'lat' => (float) $l->lat,
                'lng' => (float) $l->lng,
                'url' => route('listings.show', $l),
            ]));

            if (!listings.length) return;

            const map = L.map('map', { scrollWheelZoom: true });
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const bounds = [];
            listings.forEach(l => {
                const m = L.marker([l.lat, l.lng]).addTo(map);
                m.bindPopup(`
            <div style="min-width:180px">
              <div style="font-weight:600">${l.title}</div>
              <div style="font-size:12px;opacity:.75">${l.city}, ${l.country}</div>
              <div style="margin-top:6px;font-weight:600">${l.currency} ${l.price} <span style="font-weight:400;opacity:.75">/ night</span></div>
              <div style="margin-top:8px"><a href="${l.url}">View</a></div>
            </div>
        `);
                bounds.push([l.lat, l.lng]);
            });

            map.fitBounds(bounds, { padding: [30, 30] });
        });
    </script>
</x-app-layout>