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
                    <x-listing-card :listing="$listing" :wishlisted-ids="$wishlistedIds" />
                @endforeach
            </div>

            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
    <x-footer />
</x-app-layout>