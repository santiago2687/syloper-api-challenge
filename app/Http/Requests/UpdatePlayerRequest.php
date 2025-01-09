<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\SkillType;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|in:' . implode(',', PlayerPosition::values()),
            'playerSkills' => 'required|array|min:1',
            'playerSkills.*.skill' => 'required|in:' . implode(',', SkillType::values()),
            'playerSkills.*.value' => 'required|integer|min:0|max:100',
        ];
    }
}
