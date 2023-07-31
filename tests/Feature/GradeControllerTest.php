<?php

namespace Tests\Feature;

use App\Models\Grade;
use App\Models\Inspection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        Grade::factory()->count(3)->create();

        $response = $this->get('/api/grades');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Show test
     * @return void
     */
    public function testShow(): void
    {
        $grade = Grade::factory()->create();
        $response = $this->get('/api/grades/' . $grade->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'inspection_id',
                    'component_id',
                    'grade_type_id',
                ],
            ])
            ->assertJsonPath('data.id', $grade->id)
            ->assertJsonPath('data.inspection_id', $grade->inspection_id)
            ->assertJsonPath('data.component_id', $grade->component_id)
            ->assertJsonPath('data.grade_type_id', $grade->grade_type_id);
    }

    /**
     * Show not found test
     * @return void
     */
    public function testShowNotFound(): void
    {
        $response = $this->get('/api/grades/999');
        $response->assertStatus(404);
    }

    /**
     * Get grades by inspection test
     * @return void
     */
    public function testGetGradesByInspection(): void
    {
        $inspection = Inspection::factory()->create();
        Grade::factory()->count(3)->for($inspection)->create();

        $response = $this->get('/api/inspections/' . $inspection->id . '/grades');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Get grades by inspection not found test
     * @return void
     */
    public function testGetGradesByInspectionNotFound(): void
    {
        $response = $this->get('/api/inspections/999/grades');
        $response->assertStatus(404);
    }
}
