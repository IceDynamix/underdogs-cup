<?php

namespace App\Models;

use App\Enums\TetrioRank;
use App\Http\TetrioApi\TetrioApi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            'rank' => $user['league']['rank'],
            'best_rank' => $user['league']['bestrank'],
            'rating' => $user['league']['rating'],
            'rd' => $user['league']['rd'],
            'pps' => $user['league']['pps'],
            'apm' => $user['league']['apm'],
            'vs' => $user['league']['vs'],
            'games_played' => $user['league']['gamesplayed'],
        ];
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
        return $this->registrations()->firstWhere(['tournament_id' => $tournament->id])->exists();
    }
}
