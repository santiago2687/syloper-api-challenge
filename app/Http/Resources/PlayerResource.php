<?php

namespace App\Http\Resources;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Player */
class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'playerSkills' => $this->skills->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'skill' => $skill->skill,
                    'value' => $skill->value,
                    'playerId' => $skill->player_id,
                ];
            }),
        ];
    }
}
