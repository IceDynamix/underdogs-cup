<?php

namespace Database\Factories;

use App\Models\PlayerBlacklistEntry;
use App\Models\TetrioUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlayerBlacklistEntryFactory extends Factory
{
    protected $model = PlayerBlacklistEntry::class;

    public function definition(): array
    {
        return [
            'tetrio_id' => TetrioUser::factory(),
            'until' => $this->faker->randomElement([Carbon::now()->addYear(), null]),
            'admin_id' => User::factory(),
            'reason' => $this->faker->sentence(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
