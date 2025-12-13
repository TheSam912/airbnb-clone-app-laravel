<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bookings</h2>
                <p class="text-sm text-gray-500 mt-1">Reservations across all your listings.</p>
            </div>
            <a href="{{ route('host.listings.index') }}" class="px-4 py-2 rounded-lg border hover:bg-gray-50">
                Manage listings
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 border-b flex items-center justify-between">
                    <div class="font-medium text-gray-900">Latest bookings</div>
                    <div class="text-sm text-gray-500">Showing {{ $bookings->count() }} of {{ $bookings->total() }}
                    </div>
                </div>

                @forelse($bookings as $booking)
                    @php
                        $cover = $booking->listing?->photos?->first();
                    @endphp

                    <div class="p-4 border-b flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="w-28 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-full object-cover" alt="">
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="font-semibold text-gray-900 truncate">
                                {{ $booking->listing->title ?? 'Listing deleted' }}
                            </div>

                            <div class="text-sm text-gray-600 mt-1">
                                {{ $booking->check_in->toDateString() }} → {{ $booking->check_out->toDateString() }}
                                <span class="text-gray-300 mx-2">•</span>
                                {{ $booking->guests }} guest(s)
                            </div>

                            <div class="text-sm text-gray-600 mt-1">
                                Guest: <span class="font-medium">{{ $booking->guest->name ?? 'Unknown' }}</span>
                                <span class="text-gray-300 mx-2">•</span>
                                Status:
                                <span class="font-medium
                                                                    {{ $booking->status === 'confirmed' ? 'text-emerald-700' : '' }}
                                                                    {{ $booking->status === 'pending' ? 'text-amber-700' : '' }}
                                                                    {{ $booking->status === 'cancelled' ? 'text-red-700' : '' }}
                                                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="sm:ml-auto text-right">
                            <div class="font-semibold text-gray-900">
                                {{ $booking->listing->currency ?? '' }} {{ number_format($booking->subtotal / 100, 2) }}
                            </div>
                            @if($booking->listing)
                                <a class="text-sm underline text-gray-700"
                                    href="{{ route('host.listings.show', $booking->listing) }}">
                                    View listing
                                </a>
                            @endif
                        </div>
                        @if($booking->status !== 'cancelled')
                            <form method="POST" action="{{ route('host.bookings.cancel', $booking) }}"
                                onsubmit="return confirm('Cancel this booking for the guest?')">
                                @csrf
                                @method('PATCH')
                                <button class="inline-flex items-center justify-center px-4 py-2 rounded-lg
                                       bg-red-600 text-white font-medium
                                       hover:bg-red-700 active:bg-red-800
                                       focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        No bookings yet.
                    </div>
                @endforelse
            </div>

            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>