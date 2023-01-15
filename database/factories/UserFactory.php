<?php

namespace Database\Factories;

use App\Models\TetrioUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => fake()->randomNumber(5),
            'name' => fake()->userName(),
            'tetrio_user_id' => TetrioUser::factory(),
            'avatar' => fake()->imageUrl(200, 200),
            'is_admin' => false,
        ];
    }
}
