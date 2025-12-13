<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Wifi', 'Kitchen', 'Washer', 'Dryer', 'Air conditioning', 'Heating',
            'TV', 'Free parking', 'Pool', 'Hot tub', 'Gym', 'Pets allowed',
        ];

        foreach ($names as $name) {
            Amenity::firstOrCreate(['name' => $name]);
        }
    }
}
