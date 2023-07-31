<?php

namespace Tests\Feature;

use App\Models\Inspection;
use App\Models\Turbine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InspectionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        Inspection::factory()->count(3)->create();

        $response = $this->get('/api/inspections');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Show test
     * @return void
     */
    public function testShow(): void
    {
        $inspection = Inspection::factory()->create();
        $response = $this->get('/api/inspections/' . $inspection->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'turbine_id',
                ],
            ])
            ->assertJsonPath('data.id', $inspection->id)
            ->assertJsonPath('data.turbine_id', $inspection->turbine_id);
    }

    /**
     * Show not found test
     * @return void
     */
    public function testShowNotFound(): void
    {
        $response = $this->get('/api/inspections/999');
        $response->assertStatus(404);
    }

    /**
     * Get inspections by turbine test
     * @return void
     */
    public function testGetInspectionsByTurbine(): void
    {
        $turbine = Turbine::factory()->create();
        Inspection::factory()->count(3)->for($turbine)->create();

        $response = $this->get('/api/turbines/' . $turbine->id . '/inspections');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Get inspections by turbine not found test
     * @return void
     */
    public function testGetInspectionsByTurbineNotFound(): void
    {
        $response = $this->get('/api/turbines/999/inspections');
        $response->assertStatus(404);
    }
}
