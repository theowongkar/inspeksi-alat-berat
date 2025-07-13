<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
            'machine_type' => fake()->word(),
            'serial_number' => fake()->bothify('SN###??'),
            'make' => fake()->company(),
            'model' => fake()->word(),
            'year' => fake()->year(),
        ];
    }
}
