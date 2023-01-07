<?php

namespace App\Http\DiscordApi;

use Http;

class DiscordApi
{
    public static function userIsInGuild(string $token)
    {
        $guilds = self::getUserGuilds($token);
        $guildId = config('services.discord.guild_id');

        foreach ($guilds as $guild) {
            if ($guild['id'] == $guildId) {
                return true;
            }
        }

        return false;
    }

    public static function getUserGuilds(string $token)
    {
        return self::request('users/@me/guilds', $token);
    }

    private static function request(string $endpoint, string $token)
    {
        info("Requesting from discord/$endpoint");
        $res = Http::discord()->withToken($token)->get($endpoint);
        if (!$res->ok()) {
            return null;
        }

        return $res->json();
    }
}
