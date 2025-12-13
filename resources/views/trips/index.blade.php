<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Trips</h2>
            <p class="text-sm text-gray-500 mt-1">Your reservations will show here.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                @forelse($bookings as $booking)
                    @php $cover = $booking->listing?->photos?->first(); @endphp
                    <div class="p-4 border-b flex items-center gap-4">
                        <div class="w-24 h-16 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-full object-cover" alt="">
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold truncate">{{ $booking->listing->title ?? 'Listing deleted' }}</div>
                            <div class="text-sm text-gray-600">
                                {{ $booking->check_in->toDateString() }} → {{ $booking->check_out->toDateString() }}
                                <span class="text-gray-300 mx-2">•</span>
                                {{ ucfirst($booking->status) }}
                            </div>
                        </div>
                        <div class="ml-auto font-semibold">
                            {{ number_format($booking->subtotal / 100, 2) }}
                        </div>
                        @if($booking->status !== 'cancelled')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                                onsubmit="return confirm('Cancel this booking?')">
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
                        No trips yet. <a class="underline" href="{{ route('listings.index') }}">Browse stays</a>
                    </div>
                @endforelse
            </div>

            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>