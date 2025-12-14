<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">My wishlist</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">
        @if($listings->isEmpty())
            <div class="text-center text-gray-500 py-20">
                No saved places yet ❤️
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($listings as $listing)
                    @php $cover = $listing->photos->first(); @endphp

                    <a href="{{ route('listings.show', $listing) }}"
                        class="bg-white border rounded-2xl overflow-hidden hover:shadow-sm transition">
                        <div class="h-48 bg-gray-100">
                            @if($cover)
                                <img src="{{ asset('storage/' . $cover->path) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="font-semibold">{{ $listing->title }}</div>
                            <div class="text-sm text-gray-600">
                                {{ $listing->currency }}
                                {{ number_format($listing->price_per_night / 100, 2) }} / night
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</x-app-layout>