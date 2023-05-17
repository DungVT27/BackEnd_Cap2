<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\HelpersFacade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rooms>
 */
class RoomsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_owner' => rand(2, 105),
            'name' => fake()->country() . ' tour',
            'description' => fake()->realText(fake()->numberBetween(10,20)),
            'image'=> HelpersFacade::tripImageUrlGenerate(),
        ];
    }
}
