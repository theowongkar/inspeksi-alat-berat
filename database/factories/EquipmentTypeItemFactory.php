<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentTypeItem>
 */
class EquipmentTypeItemFactory extends Factory
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
            'category' => fake()->randomElement([
                [
                    'Cab',
                    'Engine',
                    'Hydraulics',
                    'Bucket',
                    'Functional Test',
                    'Tools',
                    'U/C',
                    'Exterior',
                    'Power Train',
                    'Inside Car',
                    'Machine Room',
                    'Top Of Car',
                    'Hoistway',
                    'Inside Hoistway',
                    'Pit',
                ]
            ]),
        ];
    }
}
