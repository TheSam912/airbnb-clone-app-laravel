<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Trips</h2>
            <p class="text-sm text-gray-500 mt-1">Your reservations will show here.</p>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                @forelse($bookings as $booking)
                            @php $cover = $booking->listing?->photos?->first(); @endphp

                            <div class="p-4 border-b">
                                <div class="flex gap-4">
                                    <div class="w-28 h-20 sm:w-24 sm:h-16 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                                        @if($cover)
                                            <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-full object-cover" alt="">
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $booking->listing->title ?? 'Listing deleted' }}
                                        </div>

                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ $booking->check_in->toFormattedDateString() }}
                                            <span class="text-gray-300 mx-1">→</span>
                                            {{ $booking->check_out->toFormattedDateString() }}
                                        </div>

                                        <div class="mt-2 flex flex-wrap items-center gap-2">
                                            <span class="text-xs px-2 py-1 rounded-full border
                                                {{ $booking->status === 'cancelled'
                    ? 'bg-gray-50 text-gray-700 border-gray-200'
                    : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>

                                            <span class="text-sm font-semibold text-gray-900">
                                                GBP {{ number_format($booking->subtotal / 100, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2">
                                    <a href="{{ route('listings.show', $booking->listing) }}"
                                        class="w-full sm:w-auto px-4 py-2 rounded-xl border text-center hover:bg-gray-50">
                                        View stay
                                    </a>

                                    @if($booking->status !== 'cancelled')
                                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                                            onsubmit="return confirm('Cancel this booking?')" class="w-full sm:w-auto">
                                            @csrf
                                            @method('PATCH')
                                            <button class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-xl
                                                               bg-red-600 text-white font-medium hover:bg-red-700 active:bg-red-800
                                                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Cancel booking
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        No trips yet.
                        <a class="underline" href="{{ route('listings.index') }}">Browse stays</a>
                    </div>
                @endforelse
            </div>

            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>