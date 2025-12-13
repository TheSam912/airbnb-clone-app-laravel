<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:30'],

            'country' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:80'],
            'address_line1' => ['required', 'string', 'max:120'],
            'address_line2' => ['nullable', 'string', 'max:120'],
            'postcode' => ['nullable', 'string', 'max:20'],

            'max_guests' => ['required', 'integer', 'min:1', 'max:16'],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'beds' => ['required', 'integer', 'min:0', 'max:30'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:20'],

            'price_per_night' => ['required', 'integer', 'min:1', 'max:2000000'], // cents
            'currency' => ['required', 'string', 'size:3'],

            'amenities' => ['array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],

            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
