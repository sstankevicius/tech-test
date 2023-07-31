<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ComponentType;
use App\Models\Farm;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\Inspection;
use App\Models\Turbine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Create a single farm
        $farm = Farm::factory()->create();

        // Create the component types
        $componentTypeNames = ['Blade', 'Rotor', 'Hub', 'Generator'];
        foreach ($componentTypeNames as $typeName) {
            ComponentType::create(['name' => $typeName]);
        }

        // Create 10 turbines for the farm
        $turbines = Turbine::factory(10)->create(['farm_id' => $farm->id]);

        // Create 4 components for each turbine, one of each type
        foreach ($turbines as $turbine) {
            foreach ($componentTypeNames as $typeName) {
                $componentType = ComponentType::where('name', $typeName)->first();
                Component::factory()->create([
                    'component_type_id' => $componentType->id,
                    'turbine_id' => $turbine->id,
                ]);
            }

            // Create an inspection for the turbine
            $inspection = Inspection::factory()->create(['turbine_id' => $turbine->id]);

            // Create grades for each component of the turbine
            $components = Component::where('turbine_id', $turbine->id)->get();
            foreach ($components as $component) {
                $gradeValue = rand(1, 5);
                $gradeType = GradeType::firstOrCreate(['name' => $gradeValue]);
                Grade::factory()->create([
                    'inspection_id' => $inspection->id,
                    'component_id' => $component->id,
                    'grade_type_id' => $gradeType->id,
                ]);
            }
        }
    }
}

