<?php

namespace Database\Factories;

use App\Models\Flood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flood>
 */
class FloodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Batas koordinat Purwokerto/Banyumas
        $minLat = -7.4500;  // Batas selatan
        $maxLat = -7.3800;  // Batas utara
        $minLng = 109.2000; // Batas barat
        $maxLng = 109.3500; // Batas timur

        return [
            'lat' => fake()->randomFloat(7, $minLat, $maxLat),
            'lng' => fake()->randomFloat(7, $minLng, $maxLng),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
            'status' => fake()->randomElement(array_values(Flood::STATUSES())),
            'province' => 'Jawa Tengah',
            'regency' => 'Banyumas',
            'district' => fake()->randomElement([
                'Purwokerto Utara',
                'Purwokerto Selatan',
                'Purwokerto Barat',
                'Purwokerto Timur',
                'Ajibarang',
                'Banyumas',
            ]),
            'village' => fake()->city(),
        ];
    }
}