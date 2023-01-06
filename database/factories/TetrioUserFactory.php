<?php

namespace Database\Factories;

use App\Http\Enums\TetrioRank;
use App\Models\TetrioUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class TetrioUserFactory extends Factory
{
    protected $model = TetrioUser::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'username' => $this->faker->userName(),
            'country' => $this->faker->countryCode(),
            'rank' => $this->faker->randomElement(TetrioRank::cases()),
            'best_rank' => $this->faker->randomElement(TetrioRank::cases()),
            'rating' => $this->faker->randomFloat(2, 0, 25000),
            'rd' => $this->faker->randomFloat(2, 50, 300),
            'pps' => $this->faker->randomFloat(2, 0, 4),
            'apm' => $this->faker->randomFloat(2, 0, 200),
            'vs' => $this->faker->randomFloat(2, 0, 400),
            'games_played' => $this->faker->randomNumber(3),
        ];
    }
}
