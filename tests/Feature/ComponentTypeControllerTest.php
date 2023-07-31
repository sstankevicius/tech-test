<?php

namespace Tests\Feature;

use App\Models\ComponentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComponentTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        ComponentType::factory()->count(3)->create();

        $response = $this->get('/api/component-types');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Show test
     * @return void
     */
    public function testShow(): void
    {
        $componentType = ComponentType::factory()->create();
        $response = $this->get('/api/component-types/' . $componentType->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ])
            ->assertJsonPath('data.id', $componentType->id)
            ->assertJsonPath('data.name', $componentType->name);
    }

    /**
     * Show not found test
     * @return void
     */
    public function testShowNotFound(): void
    {
        $response = $this->get('/api/component-types/999');
        $response->assertStatus(404);
    }
}
