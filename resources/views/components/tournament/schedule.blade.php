@php
    use App\Enums\TournamentStatus;use Carbon\Carbon;

    $timestamps = [
        'Registration open' => [TournamentStatus::RegOpen, $tournament->reg_open_ts],
        'Registration close' => [TournamentStatus::RegClosed, $tournament->reg_close_ts],
        'Check-in open' => [TournamentStatus::CheckInOpen, $tournament->check_in_open_ts],
        'Check-in close' => [TournamentStatus::CheckInClosed, $tournament->check_in_close_ts],
        'Tournament start' => [TournamentStatus::Ongoing, $tournament->tournament_start_ts]
    ];
@endphp

<div class="box">
    <div class="content">
        <h2>Schedule</h2>
        <table class="table is-hoverable is-striped">
            <tbody>
            @foreach($timestamps as $label => [$status, $ts])
                <tr>
                    <td class="@if($tournament->status == $status) has-text-weight-bold @endif">
                        {{$label}}
                    </td>
                    <td>
                        <span class="tag is-info @if($tournament->status != $status) is-light @endif">
                            {{$ts->format('D, d M Y H:i')}} UTC
                        </span>
                        <span class="tag is-gray">
                            {{$ts->diffForHumans(['parts' => 2])}}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
