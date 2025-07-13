<?php

namespace Database\Factories;

use App\Models\Inspection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InspectionInfo>
 */
class InspectionInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isElevator = fake()->boolean();

        return [
            'inspection_id' => Inspection::inRandomOrder()->first()->id,
            'report_no' => $isElevator ? null : fake()->numerify('REP-###'),
            'hour_reading' => $isElevator ? null : fake()->numberBetween(100, 10000),
            'state_id' => $isElevator ? fake()->bothify('ID-####') : null,
            'capacity' => $isElevator ? fake()->randomElement(['500kg', '1000kg', '1500kg']) : null,
        ];
    }
}
