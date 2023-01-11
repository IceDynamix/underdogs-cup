<?php

namespace App\Helper;

use App\Enums\TournamentStatus;
use App\Models\Tournament;
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
            if ($tournament->lower_reg_rank_cap->rank() > $snapshot->rank->rank()) {
                $errors[] = 'Your rank was too low on tournament announcement.';
            }

            if ($tournament->lower_reg_rank_cap->rank() > $tetrio->rank->rank()) {
                $errors[] = 'Your current rank is too low.';
            }
        }

        if ($tournament->upper_reg_rank_cap) {
            if ($tournament->upper_reg_rank_cap->rank() < $snapshot->rank->rank()) {
                $errors[] = 'Your rank was too high on tournament announcement.';
            }

            if ($tournament->upper_reg_rank_cap->rank() < $tetrio->rank->rank()) {
                $errors[] = 'Your current rank is too high.';
            }
        }

        if ($tournament->min_games_played) {
            if ($tournament->min_games_played < $snapshot->games_played) {
                $errors[] = 'You did not have enough games played on tournament announcement.';
            }
        }

        if ($tournament->max_rd) {
            if ($tournament->max_rd < $snapshot->rd) {
                $errors[] = 'Your rating deviation was too high on tournament announcement.';
            }
        }

        if ($tournament->grace_rank_cap) {
            if ($tournament->grace_rank_cap->rank() < $tetrio->best_rank->rank()) {
                $errors[] = 'Your peak rank is too high.';
            }
        }

        return $errors;
    }
}
