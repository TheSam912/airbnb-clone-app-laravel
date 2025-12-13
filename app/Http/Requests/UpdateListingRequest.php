<?php

namespace App\Http\Requests;

use App\Models\Listing;

class UpdateListingRequest extends StoreListingRequest
{
    public function authorize(): bool
    {
        $listing = $this->route('listing');

        if (! $listing instanceof Listing) {
            return false;
        }

        return $this->user()?->id === $listing->user_id;
    }
}
