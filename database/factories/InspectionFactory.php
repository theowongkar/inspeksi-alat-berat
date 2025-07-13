<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::inRandomOrder()->first()->id,
            'inspector_id' => User::where('role', 'Inspector')->inRandomOrder()->first()->id,
            'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
            'inspection_date' => fake()->date(),
            'location' => fake()->address(),
        ];
    }
}
