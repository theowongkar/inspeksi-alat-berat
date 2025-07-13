<?php

namespace Database\Factories;

use App\Models\Inspection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InspectionItem>
 */
class InspectionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inspection_id' => Inspection::inRandomOrder()->first()->id,
            'category' => fake()->randomElement([
                'cab',
                'engine',
                'hydraulics',
                'bucket',
                'functional test',
                'tools',
                'u/c',
                'exterior',
                'power train',
                'inside car',
                'machine_room',
                'top of car',
                'hoistway',
                'inside hoistway',
                'pit'
            ]),
            'score' => fake()->numberBetween(10, 100),
            'description' => fake()->sentence(),
        ];
    }
}
