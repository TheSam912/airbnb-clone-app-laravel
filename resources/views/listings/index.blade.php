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