<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit listing</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $listing->city }}, {{ strtoupper($listing->country) }}</p>
            </div>
            <a class="underline" href="{{ route('host.listings.index') }}">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="p-4 bg-green-50 border border-green-200 rounded">{{ session('status') }}</div>
            @endif

            {{-- Listing form --}}
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('host.listings.update', $listing) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @include('host.listings.form', ['listing' => $listing, 'amenities' => $amenities])

                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded bg-gray-900 text-white">Save</button>
                        <a class="px-4 py-2 rounded border"
                            href="{{ route('host.listings.show', $listing) }}">Preview</a>
                    </div>
                </form>
            </div>

            {{-- Photos card (separate forms are OK here) --}}
            <div class="bg-white shadow rounded p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Photos</h3>
                    <p class="text-sm text-gray-500">Upload and choose a cover photo.</p>
                </div>

                <form method="POST" action="{{ route('host.listings.photos.store', $listing) }}"
                    enctype="multipart/form-data" class="mt-4 flex flex-col sm:flex-row gap-3 items-start sm:items-end">
                    @csrf

                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium mb-1">Photo</label>
                        <input type="file" name="photo" accept="image/*" class="block w-full" required>
                        @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label class="block text-sm font-medium mb-1">Caption</label>
                        <input type="text" name="caption" value="{{ old('caption') }}"
                            class="w-full rounded border-gray-300" placeholder="e.g. Living room">
                        @error('caption') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button class="px-4 py-2 rounded bg-gray-900 text-white hover:bg-black">Upload</button>
                </form>

                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($listing->photos->sortBy('sort_order') as $photo)
                        <div class="border rounded-lg overflow-hidden">
                            <img class="w-full h-32 object-cover" src="{{ asset('storage/' . $photo->path) }}" alt="">
                            <div class="p-2 space-y-2">
                                <div class="text-xs text-gray-600 truncate">{{ $photo->caption ?? '—' }}</div>

                                <div class="flex items-center justify-between gap-2">
                                    @if($photo->is_cover)
                                        <span
                                            class="text-xs px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Cover
                                        </span>
                                    @else
                                        <form method="POST"
                                            action="{{ route('host.listings.photos.cover', [$listing, $photo]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="text-xs underline">Set cover</button>
                                        </form>
                                    @endif

                                    <form method="POST"
                                        action="{{ route('host.listings.photos.destroy', [$listing, $photo]) }}"
                                        onsubmit="return confirm('Delete this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs underline text-red-600">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No photos uploaded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>