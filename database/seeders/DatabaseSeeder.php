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
        $farm = Farm::factory()->create();

        $componentTypeNames = ['Blade', 'Rotor', 'Hub', 'Generator'];
        foreach ($componentTypeNames as $typeName) {
            ComponentType::create(['name' => $typeName]);
        }

        $turbines = Turbine::factory(10)->create(['farm_id' => $farm->id]);

        foreach ($turbines as $turbine) {
            foreach ($componentTypeNames as $typeName) {
                $componentType = ComponentType::where('name', $typeName)->first();
                Component::factory()->create([
                    'component_type_id' => $componentType->id,
                    'turbine_id' => $turbine->id,
                ]);
            }

            $inspection = Inspection::factory()->create(['turbine_id' => $turbine->id]);

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

