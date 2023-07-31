<?php

namespace Database\Factories;

use App\Models\Component;
use App\Models\ComponentType;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Component>
 */
class ComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'component_type_id' => ComponentType::factory(),
            'turbine_id' => Turbine::factory(),
        ];
    }
}
