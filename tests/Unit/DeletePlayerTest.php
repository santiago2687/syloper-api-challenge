<?php

namespace Tests\Unit;

use App\Exceptions\PlayerNotFoundException;
use App\Exceptions\SkillNotFoundException;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_player()
    {
        $player = Player::factory()->create();

        $response = $this->deleteJson("/api/players/{$player->id}", [], [
            'Authorization' => 'Bearer ' . env('STATIC_BEARER_TOKEN'),
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Player deleted successfully']);

        $this->assertDatabaseMissing('players', ['id' => $player->id]);
    }

    public function test_cannot_delete_player_with_invalid_id()
    {
        $response = $this->deleteJson('/api/players/9999', [], [
            'Authorization' => 'Bearer ' . env('STATIC_BEARER_TOKEN'),
        ]);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Player not found.']);
    }
}
