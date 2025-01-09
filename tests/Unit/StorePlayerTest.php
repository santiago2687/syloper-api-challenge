<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorePlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_player()
    {
        $payload = [
            'name' => 'Test Player',
            'position' => 'midfielder',
            'playerSkills' => [
                ['skill' => 'speed', 'value' => 80],
                ['skill' => 'stamina', 'value' => 90],
            ],
        ];

        $response = $this->postJson('/api/players', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'position', 'playerSkills' => [
                    '*' => ['id', 'skill', 'value', 'playerId']
                ]]
            ]);

        $this->assertDatabaseHas('players', ['name' => 'Test Player', 'position' => 'midfielder']);
        $this->assertDatabaseHas('skills', ['skill' => 'speed', 'value' => 80]);
    }

    public function test_cannot_create_player_with_invalid_skill()
    {
        $payload = [
            'name' => 'Invalid Player',
            'position' => 'forward',
            'playerSkills' => [
                ['skill' => 'invalid_skill', 'value' => 50]
            ],
        ];

        $response = $this->postJson('/api/players', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['playerSkills.0.skill']);
    }
}
