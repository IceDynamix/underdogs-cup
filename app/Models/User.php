<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\TetrioApi\TetrioApi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'avatar',
        'is_in_discord',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function tetrio(): HasOne
    {
        return $this->hasOne(TetrioUser::class, 'id', 'tetrio_user_id');
    }

    public function getLinkedTetrio(): ?string
    {
        $res = TetrioApi::getUserFromDiscordId($this->id);
        if ($res == null) {
            return null;
        }

        return $res['_id'];
    }

    public function username(): string
    {
        return $this->tetrio?->username ?? $this->name;
    }

    public function avatarUrl(): string
    {
        return $this->tetrio?->avatarUrl() ?? $this->avatar;
    }

    public function isConnected(): bool
    {
        return $this->tetrio_user_id != null;
    }

    public function url(): string
    {
        return $this->tetrio?->url() ?? '';
    }

    public function isRegisteredAt(Tournament $tournament): bool
    {
        return $this->tetrio != null && $this->tetrio->isRegisteredAt($tournament);
    }

    public function updateIsInDiscord()
    {
        $inDiscord = Redis::sismember('discord:members', $this->id);
        $this->is_in_discord = $inDiscord;
        $this->save();

        return $inDiscord;
    }
}
