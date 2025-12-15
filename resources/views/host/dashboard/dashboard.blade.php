<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Host dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Manage listings and bookings.</p>
            </div>

            <a href="{{ route('host.onboarding.listings.create') }}"
                class="px-4 py-2.5 rounded-xl bg-rose-600 text-white font-medium hover:bg-red-700">
                Airbnb your home
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- KPI cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white border rounded-2xl p-5">
                    <div class="text-sm text-gray-500">Listings</div>
                    <div class="text-3xl font-semibold text-gray-900 mt-1">{{ $totalListings }}</div>
                </div>
                <div class="bg-white border rounded-2xl p-5">
                    <div class="text-sm text-gray-500">Published</div>
                    <div class="text-3xl font-semibold text-gray-900 mt-1">{{ $publishedCount }}</div>
                </div>
                <div class="bg-white border rounded-2xl p-5">
                    <div class="text-sm text-gray-500">Drafts</div>
                    <div class="text-3xl font-semibold text-gray-900 mt-1">{{ $draftCount }}</div>
                </div>
                <div class="bg-white border rounded-2xl p-5">
                    <div class="text-sm text-gray-500">Upcoming check-ins</div>
                    <div class="text-3xl font-semibold text-gray-900 mt-1">{{ $upcomingBookings->count() }}</div>
                </div>
            </div>

            {{-- Drafts --}}
            <div class="bg-white border rounded-2xl overflow-hidden">
                <div class="p-5 border-b flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-900">Your listings</div>
                        <div class="text-sm text-gray-500">Drafts and published homes</div>
                    </div>
                    <a href="{{ route('host.onboarding.listings.create') }}"
                        class="px-4 py-2 rounded-xl border hover:bg-gray-50">
                        New listing
                    </a>
                </div>

                <div class="divide-y">
                    @forelse($listings as $listing)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <div class="font-semibold text-gray-900 truncate">{{ $listing->title }}</div>

                                    @if($listing->is_published)
                                        <span
                                            class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="text-xs px-2 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                            Draft
                                        </span>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-600 mt-1">
                                    {{ $listing->city }}, {{ strtoupper($listing->country) }}
                                    <span class="text-gray-300 mx-2">•</span>
                                    {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }} / night
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                @if(!$listing->is_published)
                                    <a href="{{ route('host.onboarding.listings.show', [$listing, 1]) }}"
                                        class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700">
                                        Continue setup
                                    </a>
                                @else
                                    <a href="{{ route('host.listings.show', $listing) }}"
                                        class="px-4 py-2 rounded-xl border text-sm hover:bg-gray-50">
                                        Preview
                                    </a>
                                    <a href="{{ route('host.listings.edit', $listing) }}"
                                        class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm hover:bg-black">
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-500">
                            No listings yet.
                            <a href="{{ route('host.onboarding.listings.create') }}" class="underline">Create your first
                                listing</a>
                        </div>
                    @endforelse
                </div>

                <div class="p-5 border-t">
                    {{ $listings->links() }}
                </div>
            </div>

            {{-- Upcoming bookings preview --}}
            <div class="bg-white border rounded-2xl overflow-hidden">
                <div class="p-5 border-b flex items-center justify-between">
                    <div class="font-semibold text-gray-900">Upcoming bookings</div>
                    <a href="{{ route('host.bookings.index') }}" class="text-sm underline">View all</a>
                </div>

                @if($upcomingBookings->isEmpty())
                    <div class="p-8 text-gray-500">No upcoming check-ins.</div>
                @else
                    <div class="divide-y">
                        @foreach($upcomingBookings as $booking)
                            <div class="p-5 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 truncate">
                                        {{ $booking->listing->title ?? 'Listing deleted' }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ $booking->check_in->toFormattedDateString() }} →
                                        {{ $booking->check_out->toFormattedDateString() }}
                                    </div>
                                </div>

                                <div class="text-sm font-semibold text-gray-900">
                                    {{ number_format($booking->subtotal / 100, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>