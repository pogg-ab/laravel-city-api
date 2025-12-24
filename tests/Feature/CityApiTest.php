<?php

namespace Tests\Feature;

use App\Repositories\CityRepository;
use Tests\TestCase;

class CityApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app(CityRepository::class)->reset();
    }

    public function test_list_cities_returns_seeded_data(): void
    {
        $response = $this->getJson('/api/cities');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonFragment(['name' => 'Addis Ababa']);
    }

    public function test_can_create_city(): void
    {
        $payload = [
            'name' => 'Dire Dawa',
            'country' => 'Ethiopia',
            'population' => 440000,
        ];

        $response = $this->postJson('/api/cities', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Dire Dawa')
            ->assertJsonPath('data.id', 4);

        $this->getJson('/api/cities')->assertJsonCount(4, 'data');
    }

    public function test_can_show_single_city(): void
    {
        $response = $this->getJson('/api/cities/1');

        $response->assertOk()
            ->assertJsonPath('data.name', 'Addis Ababa');
    }

    public function test_can_update_city(): void
    {
        $payload = [
            'name' => 'Addis Ababa Updated',
            'country' => 'Ethiopia',
            'population' => 6000000,
        ];

        $response = $this->putJson('/api/cities/1', $payload);

        $response->assertOk()
            ->assertJsonPath('data.name', 'Addis Ababa Updated')
            ->assertJsonPath('data.population', 6000000);
    }

    public function test_can_delete_city(): void
    {
        $response = $this->deleteJson('/api/cities/1');

        $response->assertNoContent();

        $this->getJson('/api/cities/1')->assertNotFound();
    }
}
