<x-host.wizard-layout :step="$step">
    <h3 class="text-lg font-semibold text-gray-900">Photos</h3>
    <p class="text-sm text-gray-500 mt-1">Upload a few great photos. Pick a cover.</p>

    {{-- Upload --}}
    <div class="mt-6 bg-gray-50 border rounded-2xl p-4">
        <form method="POST" action="{{ route('host.listings.photos.store', $listing) }}" enctype="multipart/form-data"
            class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
            @csrf

            <div class="sm:col-span-5">
                <label class="block text-sm font-medium mb-1">Photo</label>
                <input type="file" name="photo" accept="image/*" required
                    class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-gray-900 file:text-white hover:file:bg-black">
                @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-5">
                <label class="block text-sm font-medium mb-1">Caption (optional)</label>
                <input type="text" name="caption" value="{{ old('caption') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500"
                    placeholder="e.g. Living room">
                @error('caption') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <button class="w-full px-4 py-3 rounded-xl bg-gray-900 text-white font-medium hover:bg-black">
                    Upload
                </button>
            </div>
        </form>
    </div>

    {{-- Gallery --}}
    <div class="mt-6">
        @if($listing->photos->isEmpty())
            <div class="p-10 text-center text-gray-500 border rounded-2xl bg-white">
                No photos yet. Upload at least 1 photo to continue.
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($listing->photos->sortBy('sort_order') as $photo)
                    <div class="border rounded-2xl overflow-hidden bg-white">
                        <img class="w-full h-32 object-cover" src="{{ asset('storage/' . $photo->path) }}" alt="">

                        <div class="p-3 space-y-2">
                            <div class="text-xs text-gray-600 truncate">
                                {{ $photo->caption ?? '—' }}
                            </div>

                            <div class="flex items-center justify-between gap-2">
                                @if($photo->is_cover)
                                    <span
                                        class="text-xs px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Cover
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('host.listings.photos.cover', [$listing, $photo]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-xs underline">Set cover</button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('host.listings.photos.destroy', [$listing, $photo]) }}"
                                    onsubmit="return confirm('Delete this photo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs underline text-red-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Back / Next --}}
    <div class="flex items-center justify-between pt-8">
        <a href="{{ route('host.onboarding.listings.show', [$listing, 3]) }}"
            class="px-5 py-3 rounded-xl border hover:bg-gray-50">
            Back
        </a>

        <form method="POST" action="{{ route('host.onboarding.listings.store', [$listing, 4]) }}">
            @csrf
            <button class="px-5 py-3 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700">
                Next
            </button>
        </form>
    </div>
</x-host.wizard-layout>