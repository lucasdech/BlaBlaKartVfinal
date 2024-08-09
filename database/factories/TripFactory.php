<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'starting_point' => $this->faker->city,
            'ending_point' => $this->faker->city,
            'starting_at' => $this->faker->dateTimeBetween('now', rand(1, 30) . ' days'),
            'available_seats' => $this->faker->numberBetween(1, 8),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
