<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\EquipmentType;
use App\Models\InspectionInfo;
use App\Models\InspectionItem;
use App\Models\InspectionPhoto;
use Illuminate\Database\Seeder;
use App\Models\EquipmentTypeItem;
use App\Models\InspectionProblem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Seed Users ---
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'Admin',
        ]);

        // Inspectors
        User::factory(5)->create(['role' => 'Inspector']);

        // Customers
        User::factory(5)->create(['role' => 'Customer']);

        // --- Seed Equipment Types + Items ---
        $equipmentTypes = [
            'Excavator' => ['cab', 'engine', 'hydraulics', 'bucket', 'functional test', 'tools', 'u/c'],
            'Loader' => ['cab', 'engine', 'exterior', 'power train', 'hydraulics', 'functional test', 'bucket'],
            'Elevator' => ['inside car', 'machine_room', 'top of car', 'hoistway', 'inside hoistway', 'pit'],
        ];

        foreach ($equipmentTypes as $typeName => $categories) {
            $type = EquipmentType::create(['name' => $typeName]);

            foreach ($categories as $category) {
                EquipmentTypeItem::create([
                    'equipment_type_id' => $type->id,
                    'category' => $category,
                ]);
            }

            // --- Seed Equipments per Type ---
            Equipment::factory(5)->create([
                'equipment_type_id' => $type->id,
            ]);
        }

        // --- Seed Inspections per Equipment ---
        $inspectors = User::where('role', 'Inspector')->get();

        Equipment::all()->each(function ($equipment) use ($inspectors) {
            $inspection = Inspection::factory()->create([
                'equipment_id' => $equipment->id,
                'inspector_id' => $inspectors->random()->id,
                'equipment_type_id' => $equipment->equipment_type_id,
            ]);

            // Info
            $equipmentType = $equipment->equipmentType->name;

            if (in_array($equipmentType, ['Excavator', 'Loader'])) {
                InspectionInfo::factory()->create([
                    'inspection_id' => $inspection->id,
                    'report_no' => fake()->numerify('REP-###'),
                    'hour_reading' => fake()->numberBetween(100, 5000),
                    'state_id' => null,
                    'capacity' => null,
                ]);
            } else if ($equipmentType === 'Elevator') {
                InspectionInfo::factory()->create([
                    'inspection_id' => $inspection->id,
                    'report_no' => null,
                    'hour_reading' => null,
                    'state_id' => fake()->bothify('ID-####'),
                    'capacity' => fake()->randomElement(['500kg', '1000kg', '1500kg']),
                ]);
            }

            // Items
            EquipmentTypeItem::where('equipment_type_id', $equipment->equipment_type_id)
                ->get()
                ->each(function ($item) use ($inspection) {
                    InspectionItem::factory()->create([
                        'inspection_id' => $inspection->id,
                        'category' => $item->category,
                    ]);
                });

            // Problem & Photos
            if (fake()->boolean(70)) {
                $problem = InspectionProblem::factory()->create([
                    'inspection_id' => $inspection->id,
                ]);

                $photoCount = fake()->numberBetween(1, 6);
                InspectionPhoto::factory($photoCount)->create([
                    'inspection_problem_id' => $problem->id,
                ]);
            }
        });
    }
}
