<?php

namespace App\Services;

use App\Enums\SkillType;
use App\Exceptions\PlayerNotFoundException;
use App\Exceptions\SkillNotFoundException;
use App\Models\Player;
use Illuminate\Support\Collection;

class PlayerService
{
    public function createPlayer(array $data): Player
    {
        $player = Player::query()->create([
            'name' => $data['name'],
            'position' => $data['position'],
        ]);

        foreach ($data['playerSkills'] as $skillData) {
            $this->validateSkill($skillData['skill']);
            $player->skills()->create($skillData);
        }
        $player->save();
        return $player->load('skills');
    }

    public function findPlayerOrFail(int $id): Player
    {
        $player = Player::query()->find($id);

        if (!$player) {
            throw new PlayerNotFoundException();
        }

        return $player;
    }

    public function updatePlayer(int $playerId, array $data): Player
    {
        $player = $this->findPlayerOrFail($playerId);
        $player->update([
            'name' => $data['name'],
            'position' => $data['position'],
        ]);

        $player->skills()->delete();

        foreach ($data['playerSkills'] as $skillData) {
            $this->validateSkill($skillData['skill']);
            $player->skills()->create($skillData);
        }

        return $player->load('skills');
    }

    public function deletePlayerOrFail(int $playerId): void
    {
        $player = $this->findPlayerOrFail($playerId);
        $player->delete();
    }

    public function processTeam(array $requirements): Collection
    {
        $team = collect();

        foreach ($requirements as $requirement) {
            $position = $requirement['position'];
            $mainSkill = $requirement['mainSkill'];
            $numberOfPlayers = $requirement['numberOfPlayers'];

            $this->validateSkill($mainSkill);

            $candidates = Player::where('position', $position)
                ->with('skills')
                ->get()
                ->sortByDesc(function ($player) use ($mainSkill) {
                    $skillValue = $player->skills->firstWhere('skill', $mainSkill)->value ?? 0;
                    $maxSkillValue = $player->skills->max('value');
                    return max($skillValue, $maxSkillValue);
                });

            if ($candidates->count() < $numberOfPlayers) {
                throw new PlayerNotFoundException("Insufficient number of players for position: $position");
            }

            $selectedPlayers = $candidates->take($numberOfPlayers);
            $team = $team->merge($selectedPlayers);
        }

        return $team;
    }

    private function validateSkill(string $skill): void
    {
        if (!in_array($skill, SkillType::values())) {
            throw new SkillNotFoundException();
        }
    }
}
