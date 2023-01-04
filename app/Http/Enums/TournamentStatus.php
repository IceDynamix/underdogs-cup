<?php

namespace App\Http\Enums;

enum TournamentStatus: string
{
    case Upcoming = 'upcoming';
    case RegOpen = 'reg_open';
    case RegClosed = 'reg_closed';
    case CheckInOpen = 'check_in_open';
    case CheckInClosed = 'check_in_closed';
    case Ongoing = 'ongoing';
    case Concluded = 'concluded';
}
