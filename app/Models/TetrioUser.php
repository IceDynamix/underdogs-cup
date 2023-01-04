<?php

namespace App\Models;

use App\Http\TetrioApi\TetrioApi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TetrioUser extends Model
{
    protected $fillable = [
        'id',
        'username',
        'country',
        'avatar_revision',
        'rank',
        'best_rank',
        'rating',
        'rd',
        'pps',
        'apm',
        'vs',
        'games_played',
    ];

    public static function mapTetrioUserToDbFill(array $user): array
    {
        return [
            'username' => $user['username'],
            'country' => $user['country'],
            'avatar_revision' => $user['avatar_revision'],
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

    public function snapshotUser(): HasOne
    {
        return $this->hasOne(TetrioUserSnapshot::class, 'id', 'id');
    }

    public static function updateOrCreateFromId(string $id): ?TetrioUser
    {
        $tetrioUser = TetrioApi::getUserInfo($id);
        if ($tetrioUser == null) return null;

        return TetrioUser::updateOrCreate(
            ['id' => $tetrioUser['_id']],
            self::mapTetrioUserToDbFill($tetrioUser)
        );
    }
}
