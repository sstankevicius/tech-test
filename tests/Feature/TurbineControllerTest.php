<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Models\Turbine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurbineControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        Turbine::factory()->count(3)->create();

        $response = $this->get('/api/turbines');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Show test
     * @return void
     */
    public function testShow(): void
    {
        $turbine = Turbine::factory()->create();
        $response = $this->get('/api/turbines/' . $turbine->id);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'farm_id',
                ],
            ])
            ->assertJsonPath('data.id', $turbine->id)
            ->assertJsonPath('data.name', $turbine->name)
            ->assertJsonPath('data.farm_id', $turbine->farm_id);
    }

    /**
     * Show not found test
     * @return void
     */
    public function testShowNotFound(): void
    {
        $response = $this->get('/api/turbines/999');
        $response->assertStatus(404);
    }

    /**
     * Get turbines by farm test
     * @return void
     */
    public function testGetTurbinesByFarm(): void
    {
        $farm = Farm::factory()->create();
        $turbines = Turbine::factory()->count(3)->for($farm)->create();

        $response = $this->get('/api/farms/' . $farm->id . '/turbines');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Get turbines by farm not found test
     * @return void
     */
    public function testGetTurbinesByFarmNotFound(): void
    {
        $response = $this->get('/api/farms/999/turbines');
        $response->assertStatus(404);
    }
}
