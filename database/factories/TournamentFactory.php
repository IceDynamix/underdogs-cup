<?php

namespace Database\Factories;

use App\Http\Enums\TournamentStatus;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TournamentFactory extends Factory
{
    protected $model = Tournament::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'bracket_url' => $this->faker->url(),
            'status' => TournamentStatus::Upcoming,
            'hidden' => false,
            'description' => $this->faker->text(),
            'reg_open_ts' => Carbon::now(),
            'reg_close_ts' => Carbon::now(),
            'check_in_open_ts' => Carbon::now(),
            'check_in_close_ts' => Carbon::now(),
            'tournament_start_ts' => Carbon::now(),
        ];
    }
}
