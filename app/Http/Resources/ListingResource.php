<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $cover = $this->photos->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->whenLoaded('description', $this->description),
            'city' => $this->city,
            'country' => $this->country,
            'lat' => $this->lat,
            'lng' => $this->lng,

            'currency' => $this->currency,
            'price_per_night' => $this->price_per_night, // cents
            'price_per_night_formatted' => number_format($this->price_per_night / 100, 2),

            'max_guests' => $this->max_guests,
            'bedrooms' => $this->bedrooms,
            'beds' => $this->beds,
            'bathrooms' => $this->bathrooms,

            'cover_photo_url' => $cover ? asset('storage/'.$cover->path) : null,

            'host' => $this->whenLoaded('host', fn () => [
                'id' => $this->host->id,
                'name' => $this->host->name,
            ]),

            'amenities' => $this->whenLoaded('amenities', fn () => $this->amenities->map(fn ($a) => ['id' => $a->id, 'name' => $a->name])
            ),

            'photos' => $this->whenLoaded('photos', fn () => $this->photos->map(fn ($p) => [
                'id' => $p->id,
                'url' => asset('storage/'.$p->path),
                'is_cover' => (bool) $p->is_cover,
                'caption' => $p->caption,
            ])
            ),
        ];
    }
}
