<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'position' => $this->position,
            'playerSkills' => $this->skills->map(function ($skill) {
                return [
                    'skill' => $skill->skill,
                    'value' => $skill->value,
                ];
            }),
        ];
    }
}
