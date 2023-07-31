<?php

namespace Database\Factories;

use App\Models\Inspection;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inspection>
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
            'turbine_id' => Turbine::factory(),
            'inspected_at' => $this->faker->dateTime,
            ];
    }
}
