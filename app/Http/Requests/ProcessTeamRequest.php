<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\SkillType;
use Illuminate\Foundation\Http\FormRequest;

class ProcessTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            '*.position' => 'required|in:' . implode(',', PlayerPosition::values()),
            '*.mainSkill' => 'required|in:' . implode(',', SkillType::values()),
            '*.numberOfPlayers' => 'required|integer|min:1',
        ];
    }
}
