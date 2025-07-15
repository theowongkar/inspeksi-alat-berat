<?php

namespace Database\Factories;

use App\Models\EquipmentTypeItem;
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
            'equipment_type_item_id' => EquipmentTypeItem::inRandomOrder()->first()->id,
            'score' => fake()->numberBetween(10, 100),
            'description' => fake()->sentence(),
        ];
    }
}
