<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stays</h2>
                <p class="text-sm text-gray-500 mt-1">Browse published listings.</p>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($listings as $listing)
                    @php $cover = $listing->photos->first(); @endphp
                    <a href="{{ route('listings.show', $listing) }}"
                        class="block bg-white border rounded-xl overflow-hidden hover:shadow">
                        <div class="h-44 bg-gray-100">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-44 object-cover" alt="">
                            @endif
                        </div>

                        <div class="p-4 space-y-1">
                            <div class="text-sm text-gray-600">{{ $listing->city }}, {{ strtoupper($listing->country) }}
                            </div>
                            <div class="font-semibold text-gray-900 truncate">{{ $listing->title }}</div>
                            <div class="text-sm text-gray-700">
                                {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }} <span
                                    class="text-gray-500">/ night</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>