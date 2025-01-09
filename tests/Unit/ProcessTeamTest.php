<?php

namespace Tests\Unit;

use App\Models\Player;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_process_team_with_best_players()
    {
        $player1 = Player::factory()->create(['position' => 'defender']);
        $player2 = Player::factory()->create(['position' => 'defender']);

        $player1->skills()->create(['skill' => 'defense', 'value' => 80]);
        $player2->skills()->create(['skill' => 'defense', 'value' => 85]);

        $payload = [
            ['position' => 'defender', 'mainSkill' => 'defense', 'numberOfPlayers' => 1]
        ];

        $response = $this->postJson('/api/teams/process', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'position', 'playerSkills' => [
                        '*' => ['skill', 'value']
                    ]]
                ]
            ]);
    }

    public function test_can_process_team_with_best_alternative_skill()
    {
        $player1 = Player::factory()->create(['position' => 'defender']);
        $player2 = Player::factory()->create(['position' => 'defender']);

        $player1->skills()->create(['skill' => 'speed', 'value' => 70]);
        $player2->skills()->create(['skill' => 'strength', 'value' => 90]);

        $payload = [
            ['position' => 'defender', 'mainSkill' => 'defense', 'numberOfPlayers' => 1]
        ];

        $response = $this->postJson('/api/teams/process', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'position', 'playerSkills' => [
                        '*' => ['skill', 'value']
                    ]]
                ]
            ]);

    }

    public function test_insufficient_players_for_position()
    {
        Player::factory()->create(['position' => 'midfielder']);

        $payload = [
            ['position' => 'defender', 'mainSkill' => 'defense', 'numberOfPlayers' => 2]
        ];

        $response = $this->postJson('/api/teams/process', $payload);

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Insufficient number of players for position: defender']);
    }
}
