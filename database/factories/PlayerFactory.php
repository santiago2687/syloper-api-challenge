<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement(['defender', 'midfielder', 'forward']),
        ];
    }

    public function withSkills(array $skills = [])
    {
        return $this->afterCreating(function (Player $player) use ($skills) {
            foreach ($skills as $skill) {
                $player->skills()->create($skill);
            }
        });
    }
}
