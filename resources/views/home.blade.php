<x-app-layout>
    <div class="bg-white">
        {{-- Hero --}}
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-slate-50"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-7">
                        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
                            Find your next stay
                        </h1>
                        <p class="mt-4 text-lg text-gray-600 max-w-xl">
                            Book unique places to stay, explore new cities, and build your hosting business — all in one
                            app.
                        </p>

                        {{-- Search card (UI only for now) --}}
                        <form method="GET" action="{{ route('listings.index') }}"
                            class="mt-8 bg-white/80 backdrop-blur border border-gray-200 rounded-2xl p-4 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                <div class="md:col-span-5">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Where</label>
                                    <input type="text" name="city" placeholder="Search by city"
                                        class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Guests</label>
                                    <input type="number" name="guests" min="1"
                                        class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500">
                                </div>

                                <div class="md:col-span-4 flex items-end">
                                    <button
                                        class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('listings.index') }}"
                                class="px-5 py-3 rounded-xl bg-gray-900 text-white hover:bg-black">
                                Explore stays
                            </a>

                            @auth
                                <a href="{{ route('host.listings.index') }}"
                                    class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                                    Host dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl border hover:bg-gray-50">
                                    Become a member
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Right visual card --}}
                    <div class="lg:col-span-5">
                        <div class="rounded-3xl border bg-white shadow-sm overflow-hidden">
                            <div class="p-5 border-b">
                                <div class="text-sm font-medium text-gray-900">Popular this week</div>
                                <div class="text-xs text-gray-500 mt-1">Hand-picked stays from your latest listings.
                                </div>
                            </div>
                            <div class="p-5 space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="h-20 rounded-2xl bg-gradient-to-br from-red-200 to-red-50"></div>
                                    <div class="h-20 rounded-2xl bg-gradient-to-br from-slate-200 to-slate-50"></div>
                                    <div class="h-20 rounded-2xl bg-gradient-to-br from-amber-200 to-amber-50"></div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    Build a real marketplace experience: listings, photos, bookings, and host tools.
                                </div>
                                <a href="{{ route('listings.index') }}"
                                    class="text-sm font-medium text-red-600 hover:text-red-700">
                                    Browse all stays →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Featured stays</h2>
                    <p class="text-gray-600 mt-1">A few great places to get started.</p>
                </div>
                <a href="{{ route('listings.index') }}" class="text-sm font-medium text-red-600 hover:text-red-700">
                    View all →
                </a>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featured as $listing)
                    @php $cover = $listing->photos->first(); @endphp

                    <a href="{{ route('listings.show', $listing) }}"
                        class="group bg-white border rounded-2xl overflow-hidden hover:shadow-sm transition">
                        <div class="h-48 bg-gray-100">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover->path) }}"
                                    class="w-full h-48 object-cover group-hover:scale-[1.02] transition" alt="">
                            @endif
                        </div>

                        <div class="p-4 space-y-1">
                            <div class="text-sm text-gray-600">{{ $listing->city }}, {{ strtoupper($listing->country) }}
                            </div>
                            <div class="font-semibold text-gray-900 truncate">{{ $listing->title }}</div>
                            <div class="text-sm text-gray-800">
                                {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }}
                                <span class="text-gray-500">/ night</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full p-10 text-center text-gray-500 border rounded-2xl bg-gray-50">
                        No published listings yet. Publish one from your host dashboard.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Host CTA --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
            <div class="rounded-3xl overflow-hidden border bg-gradient-to-br from-gray-900 to-gray-800 text-white">
                <div class="p-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8">
                        <h3 class="text-2xl font-bold">Ready to host?</h3>
                        <p class="mt-2 text-white/80">
                            Create a listing, upload photos, and start receiving bookings.
                        </p>
                    </div>
                    <div class="lg:col-span-4 flex lg:justify-end">
                        @auth
                            <a href="{{ route('host.listings.create') }}"
                                class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 font-medium">
                                Create a listing
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 font-medium">
                                Sign up to host
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>