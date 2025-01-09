<?php

namespace Tests\Unit;

use App\Models\Player;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_player()
    {
        $player = Player::factory()->create();
        Skill::factory()->create(['player_id' => $player->id, 'skill' => 'defense', 'value' => 50]);

        $payload = [
            'name' => 'Updated Player',
            'position' => 'defender',
            'playerSkills' => [
                ['skill' => 'defense', 'value' => 70]
            ],
        ];

        $response = $this->putJson("/api/players/{$player->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'position', 'playerSkills' => [
                    '*' => ['id', 'skill', 'value', 'playerId']
                ]]
            ]);

        $this->assertDatabaseHas('players', ['id' => $player->id, 'name' => 'Updated Player']);
        $this->assertDatabaseHas('skills', ['skill' => 'defense', 'value' => 70]);
    }

    public function test_cannot_update_player_with_nonexistent_skill()
    {
        $player = Player::factory()->create();
        Skill::factory()->create(['player_id' => $player->id, 'skill' => 'defense', 'value' => 50]);

        $payload = [
            'name' => 'Updated Player',
            'position' => 'defender',
            'playerSkills' => [
                ['skill' => 'nonexistent_skill', 'value' => 70]
            ],
        ];

        $response = $this->putJson("/api/players/{$player->id}", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['playerSkills.0.skill']);
    }
}
