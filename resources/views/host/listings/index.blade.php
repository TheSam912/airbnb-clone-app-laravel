<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your listings</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your homes, pricing, and publishing status.</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('host.onboarding.listings.start') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                        <span class="text-sm font-medium">Create</span>
                </a>
</div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-xl p-4 border">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $listings->total() }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-4 border">
                    <div class="text-sm text-gray-500">Published</div>
                    <div class="text-2xl font-semibold text-gray-900">
                        {{ $listings->getCollection()->where('is_published', true)->count() }}
                    </div>
                </div>
                <div class="bg-white shadow-sm rounded-xl p-4 border">
                    <div class="text-sm text-gray-500">Drafts</div>
                    <div class="text-2xl font-semibold text-gray-900">
                        {{ $listings->getCollection()->where('is_published', false)->count() }}
                    </div>
                </div>
            </div>

            {{-- List --}}
            <div class="bg-white shadow-sm rounded-xl border overflow-hidden">
                <div class="p-4 border-b flex items-center justify-between">
                    <div class="font-medium text-gray-900">Listings</div>
                    <div class="text-sm text-gray-500">Showing {{ $listings->count() }} of {{ $listings->total() }}</div>
                </div>

                @if($listings->count() === 0)
                    <div class="p-10 text-center">
                        <div class="text-lg font-semibold text-gray-900">No listings yet</div>
                        <p class="text-gray-500 mt-2">Create your first listing to start hosting.</p>
                        <a href="{{ route('host.listings.create') }}"
                           class="inline-flex mt-5 px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                            Create listing
                        </a>
                    </div>
                @else
                    <div class="divide-y">
                        @foreach ($listings as $listing)
                            <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $listing->title }}
                                        </div>

                                        @if($listing->is_published)
                                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Published
                                            </span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                                Draft
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-sm text-gray-600 mt-1">
                                        {{ $listing->city }}, {{ strtoupper($listing->country) }}
                                        <span class="text-gray-300 mx-2">•</span>
                                        {{ $listing->max_guests }} guests
                                        <span class="text-gray-300 mx-2">•</span>
                                        {{ $listing->currency }} {{ number_format($listing->price_per_night / 100, 2) }} / night
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        Updated {{ $listing->updated_at->diffForHumans() }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('host.listings.show', $listing) }}"
                                       class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50">
                                        Preview
                                    </a>
                                    <a href="{{ route('host.listings.edit', $listing) }}"
                                       class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-black">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('host.listings.destroy', $listing) }}"
                                          onsubmit="return confirm('Delete this listing? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-2 rounded-lg border border-red-200 text-red-700 text-sm hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 border-t">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>