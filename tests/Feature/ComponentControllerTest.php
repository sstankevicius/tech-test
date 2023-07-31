<?php

namespace Tests\Feature;

use App\Models\Component;
use App\Models\Turbine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComponentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        Component::factory()->count(3)->create();

        $response = $this->get('/api/components');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Get components by turbine test
     * @return void
     */
    public function testGetComponentsByTurbine(): void
    {
        $turbine = Turbine::factory()->create();
        $components = Component::factory()->count(3)->for($turbine)->create();

        $response = $this->get('/api/turbines/' . $turbine->id . '/components');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'component_type_id',
                        'turbine_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
            ->assertJsonPath('data.0.id', $components[0]->id)
            ->assertJsonPath('data.0.component_type_id', $components[0]->component_type_id)
            ->assertJsonPath('data.0.turbine_id', $components[0]->turbine_id)
            ->assertJsonPath('data.0.created_at', $components[0]->created_at->toJSON())
            ->assertJsonPath('data.0.updated_at', $components[0]->updated_at->toJSON())
            ->assertJsonPath('data.1.id', $components[1]->id)
            ->assertJsonPath('data.1.component_type_id', $components[1]->component_type_id)
            ->assertJsonPath('data.1.turbine_id', $components[1]->turbine_id)
            ->assertJsonPath('data.1.created_at', $components[1]->created_at->toJSON())
            ->assertJsonPath('data.1.updated_at', $components[1]->updated_at->toJSON())
            ->assertJsonPath('data.2.id', $components[2]->id)
            ->assertJsonPath('data.2.component_type_id', $components[2]->component_type_id)
            ->assertJsonPath('data.2.turbine_id', $components[2]->turbine_id)
            ->assertJsonPath('data.2.created_at', $components[2]->created_at->toJSON())
            ->assertJsonPath('data.2.updated_at', $components[2]->updated_at->toJSON());
    }

    /**
     * Get components by turbine not found test
     * @return void
     */
    public function testGetComponentsByTurbineNotFound(): void
    {
        $response = $this->get('/api/turbines/999/components');
        $response->assertStatus(404);
    }
}
