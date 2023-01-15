<?php

namespace App\Helper;

use App\Enums\TournamentStatus;
use App\Events\UserUnregisteredEvent;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;

class RegistrationHelper
{
    public static function getRegistrationErrors(Tournament $tournament, User $user, bool $recheck = false): array
    {
        $errors = [];

        if (!$recheck && $user->isRegisteredAt($tournament)) {
            $errors[] = 'Already registered for this tournament.';
        }

        if ($user->is_admin) {
            // Early return because admin is da boss
            return $errors;
        }

        if (!$recheck && $tournament->status != TournamentStatus::RegOpen) {
            $errors[] = 'Registrations are closed right now.';
        }

        if ($user->is_blacklisted) {
            $errors[] = 'You have placed top 3 in a previous Underdogs Cup before or have been blacklisted for other reasons. Please contact a staff member if you think this is an accident.';
        }

        if (!$user->is_in_discord) {
            $errors[] = 'You have not joined the Discord server yet. Please join the Discord server and refresh the page.';
        }

        $tetrio = $user->tetrio;

        if ($tetrio == null) {
            $errors[] = 'TETR.IO account not linked';

            return $errors;
        }

        $snapshot = $user->tetrio->snapshotFor($tournament);

        if ($user->tetrio->snapshotFor($tournament) == null) {
            $errors[] = 'You were unranked on tournament announcement.';

            return $errors;
        }

        if ($tournament->lower_reg_rank_cap) {
            if ($snapshot->rank->rank() < $tournament->lower_reg_rank_cap->rank()) {
                $errors[] = 'Your rank was too low on tournament announcement.';
            }

            if ($tetrio->rank->rank() < $tournament->lower_reg_rank_cap->rank()) {
                $errors[] = 'Your current rank is too low.';
            }
        }

        if ($tournament->upper_reg_rank_cap) {
            if ($snapshot->rank->rank() > $tournament->upper_reg_rank_cap->rank()) {
                $errors[] = 'Your rank was too high on tournament announcement.';
            }

            if (!$tournament->grace_rank_cap) {
                if ($tetrio->best_rank->rank() > $tournament->upper_reg_rank_cap->rank()) {
                    $errors[] = 'Your peak rank is too high.';
                }
            }
        }

        if ($tournament->grace_rank_cap) {
            if ($snapshot->best_rank->rank() >= $tournament->grace_rank_cap->rank()) {
                $errors[] = 'Your peak rank before tournament announcement was too high.';
            }

            if ($tetrio->best_rank->rank() > $tournament->grace_rank_cap->rank()) {
                $errors[] = 'Your peak rank is too high.';
            }
        }

        if ($tournament->min_games_played) {
            if ($snapshot->games_played > $tournament->min_games_played) {
                $errors[] = 'You did not have enough games played on tournament announcement.';
            }
        }

        if ($tournament->max_rd) {
            if ($snapshot->rd > $tournament->max_rd) {
                $errors[] = 'Your rating deviation was too high on tournament announcement.';
            }
        }


        return $errors;
    }

    public static function unregister(TournamentRegistration $registration, array $reasons = []): ?bool
    {
        $result = $registration->delete();
        if ($result) {
            UserUnregisteredEvent::dispatch($registration->user->user, $registration->tournament, $reasons);
        }
        return $result;
    }
}
