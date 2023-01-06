<?php

namespace App\Enums;

enum TournamentStatus: string
{
    case Upcoming = 'upcoming';
    case RegOpen = 'reg_open';
    case RegClosed = 'reg_closed';
    case CheckInOpen = 'check_in_open';
    case CheckInClosed = 'check_in_closed';
    case Ongoing = 'ongoing';
    case Concluded = 'concluded';

    public function proper(): string
    {
        return match ($this) {
            self::Upcoming => 'Upcoming',
            self::RegOpen => 'Registrations open',
            self::RegClosed => 'Registrations closed',
            self::CheckInOpen => 'Check-ins open',
            self::CheckInClosed => 'Check-ins closed',
            self::Ongoing => 'Ongoing',
            self::Concluded => 'Concluded',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::Upcoming, self::Concluded => 'is-white',
            self::RegOpen => 'is-success',
            self::RegClosed => 'is-danger',
            self::CheckInOpen => 'is-info',
            self::CheckInClosed => 'is-warning',
            self::Ongoing => 'is-primary',
        };
    }
}
