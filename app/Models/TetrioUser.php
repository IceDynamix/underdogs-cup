<?php

namespace App\Models;

use App\Enums\TetrioRank;
use App\Http\TetrioApi\TetrioApi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TetrioUser extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'username',
        'country',
        'rank',
        'best_rank',
        'rating',
        'rd',
        'pps',
        'apm',
        'vs',
        'games_played',
    ];

    protected $casts = [
        'rank' => TetrioRank::class,
        'best_rank' => TetrioRank::class,
    ];

    public static function updateOrCreateFromId(string $id): ?TetrioUser
    {
        $tetrioUser = TetrioApi::getUserInfo($id);
        if ($tetrioUser == null) {
            return null;
        }

        return TetrioUser::updateOrCreate(
            ['id' => $tetrioUser['_id']],
            self::mapTetrioUserToDbFill($tetrioUser)
        );
    }

    public static function mapTetrioUserToDbFill(array $user): array
    {
        return [
            'username' => $user['username'],
            'country' => $user['country'],
            'rank' => $user['league']['rank'] ?? TetrioRank::Unranked,
            'best_rank' => $user['league']['bestrank'] ?? TetrioRank::Unranked,
            'rating' => $user['league']['rating'] ?? 0,
            'rd' => $user['league']['rd'] ?? 300,
            'pps' => $user['league']['pps'] ?? 0,
            'apm' => $user['league']['apm'] ?? 0,
            'vs' => $user['league']['vs'] ?? 0,
            'games_played' => $user['league']['gamesplayed'] ?? 0,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'tetrio_user_id');
    }

    public function avatarUrl(): string
    {
        // https://tetr.io/about/api/#usersuser
        return 'https://tetr.io/user-content/avatars/'.$this->id.'.jpg';
    }

    public function url(): string
    {
        return "https://ch.tetr.io/u/$this->username";
    }

    // for some reason making a regular relationship doesn't work so have this scuffed workaround instead
    public function snapshotFor(Tournament $tournament)
    {
        return TetrioUserSnapshot::firstWhere(['user_id' => $this->id, 'tournament_id' => $tournament->id]);
    }

    public function updateFromApi()
    {
        $tetrioUser = TetrioApi::getUserInfo($this->id);
        if ($tetrioUser == null) {
            return null;
        }

        return $this->update(self::mapTetrioUserToDbFill($tetrioUser));
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(TournamentRegistration::class, 'tetrio_user_id');
    }

    public function isRegisteredAt(Tournament $tournament): bool
    {
        return $this->registrations()->firstWhere(['tournament_id' => $tournament->id]) != null;
    }

    public function isCheckedInFor(Tournament $tournament): bool
    {
        $reg = $this->registrations()->firstWhere(['tournament_id' => $tournament->id]);
        return $reg != null && $reg->checked_in;
    }

    public function blacklistEntries(): HasMany
    {
        return $this->hasMany(PlayerBlacklistEntry::class, 'tetrio_id', 'id');
    }

    public function isBlacklisted(): bool
    {
        return $this->blacklistEntries()
                ->where(function (Builder $query) {
                    $query->where('until', '>', Carbon::now())
                        ->orWhere('until', null);
                })->first() != null;
    }
}
