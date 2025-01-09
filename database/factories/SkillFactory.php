<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'skill' => $this->faker->randomElement(['speed', 'stamina', 'defense', 'attack', 'strength']),
            'value' => $this->faker->numberBetween(50, 100),
        ];
    }
}
