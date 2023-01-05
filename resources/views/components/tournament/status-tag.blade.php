@php use App\Http\Enums\TournamentStatus; @endphp
@switch($status)
    @case(TournamentStatus::Upcoming)
        <span class="tag is-white">Upcoming</span>
        @break
    @case(TournamentStatus::RegOpen)
        <span class="tag is-success">Registrations open</span>
        @break
    @case(TournamentStatus::RegClosed)
        <span class="tag is-danger">Registrations closed, tournament upcoming</span>
        @break
    @case(TournamentStatus::CheckInOpen)
        <span class="tag is-info">Check-ins open</span>
        @break
    @case(TournamentStatus::CheckInClosed)
        <span class="tag is-warning">Check-ins closed</span>
        @break
    @case(TournamentStatus::Ongoing)
        <span class="tag is-primary">Ongoing</span>
        @break
    @case(TournamentStatus::Concluded)
        <span class="tag is-white">Concluded</span>
        @break
    @default
        <span class="tag is-white">{{ucfirst($status)}}</span>
@endswitch
