<?php

namespace Tests\Feature;

use App\Models\Farm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Index test
     * @return void
     */
    public function testIndex(): void
    {
        Farm::factory()->count(3)->create();

        $response = $this->get('/api/farms');
        $response->assertStatus(200)->assertJsonCount(3, 'data');
    }

    /**
     * Show test
     * @return void
     */
    public function testShow(): void
    {
        $farm = Farm::factory()->create();
        $response = $this->get('/api/farms/' . $farm->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJsonPath('data.id', $farm->id)
            ->assertJsonPath('data.name', $farm->name)
            ->assertJsonPath('data.created_at', $farm->created_at->toJSON())
            ->assertJsonPath('data.updated_at', $farm->updated_at->toJSON());
    }

    /**
     * Show not found test
     * @return void
     */
    public function testShowNotFound(): void
    {
        $response = $this->get('/api/farms/999');
        $response->assertStatus(404);
    }

}
