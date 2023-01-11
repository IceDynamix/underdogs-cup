<?php

namespace App\Jobs;

use App\Enums\TournamentStatus;
use App\Events\UserUnregisteredEvent;
use App\Helper\RegistrationHelper;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TournamentCheckUnregisterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        Tournament::where('status', TournamentStatus::RegOpen)
            ->each(function ($tournament) {
                $name = $tournament->name;
                info("Checking $name participants for registration errors");

                $beforeCount = $tournament->participants->count();
                $tournament->participants->each(function ($tetrioUser) use ($tournament) {
                    $user = $tetrioUser->user;
                    $user->updateIsInDiscord();

                    $errors = RegistrationHelper::getRegistrationErrors($tournament, $user, true);

                    info($errors);
                    // "Already registered" error is always included
                    if (sizeof($errors) > 0) {
                        TournamentRegistration::firstWhere([
                            'tetrio_user_id' => $user->tetrio->id,
                            'tournament_id' => $tournament->id,
                        ])->delete();

                        UserUnregisteredEvent::dispatch($user, $tournament, $errors);
                    }
                });

                $afterCount = $tournament->participants->count();

                info("Participants count $beforeCount -> $afterCount");
            });
    }
}
