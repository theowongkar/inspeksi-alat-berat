<?php

namespace Database\Factories;

use App\Models\InspectionProblem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InspectionPhoto>
 */
class InspectionPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inspection_problem_id' => InspectionProblem::inRandomOrder()->first()->id,
            'photo_url' => fake()->imageUrl(640, 480, 'technics'),
        ];
    }
}
