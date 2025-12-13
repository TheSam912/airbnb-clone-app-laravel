@php
    $selectedAmenityIds = old('amenities', $listing?->amenities?->pluck('id')->all() ?? []);
@endphp

<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium">Title</label>
        <input name="title" value="{{ old('title', $listing->title ?? '') }}"
            class="mt-1 w-full rounded border-gray-300" />
        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Description</label>
        <textarea name="description" rows="5"
            class="mt-1 w-full rounded border-gray-300">{{ old('description', $listing->description ?? '') }}</textarea>
        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Country (2 letters)</label>
            <input name="country" value="{{ old('country', $listing->country ?? '') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('country') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">City</label>
            <input name="city" value="{{ old('city', $listing->city ?? '') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('city') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Address line 1</label>
            <input name="address_line1" value="{{ old('address_line1', $listing->address_line1 ?? '') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('address_line1') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Address line 2</label>
            <input name="address_line2" value="{{ old('address_line2', $listing->address_line2 ?? '') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('address_line2') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Postcode</label>
            <input name="postcode" value="{{ old('postcode', $listing->postcode ?? '') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('postcode') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium">Max guests</label>
            <input type="number" name="max_guests" min="1" max="16"
                value="{{ old('max_guests', $listing->max_guests ?? 1) }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('max_guests') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Bedrooms</label>
            <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $listing->bedrooms ?? 1) }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('bedrooms') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Beds</label>
            <input type="number" name="beds" min="0" value="{{ old('beds', $listing->beds ?? 1) }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('beds') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Bathrooms</label>
            <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $listing->bathrooms ?? 1) }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('bathrooms') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">Price per night (cents)</label>
            <input type="number" name="price_per_night" min="1"
                value="{{ old('price_per_night', $listing->price_per_night ?? 10000) }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('price_per_night') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Currency</label>
            <input name="currency" value="{{ old('currency', $listing->currency ?? 'USD') }}"
                class="mt-1 w-full rounded border-gray-300" />
            @error('currency') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $listing->is_published ?? false)) />
            <span class="text-sm">Published</span>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Amenities</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            @foreach ($amenities as $amenity)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" @checked(in_array($amenity->id, $selectedAmenityIds)) />
                    <span class="text-sm">{{ $amenity->name }}</span>
                </label>
            @endforeach
        </div>
        @error('amenities') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>