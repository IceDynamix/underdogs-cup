<?php

namespace App\Http\TetrioApi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TetrioApi
{
    private static function request(string $endpoint, array $query = [], ?string $defaultKey = null, bool $cache = true, int $maxTimeoutInSecs = 10)
    {
        $cacheKey = 'tetrio/' . $endpoint . '?' . implode('&', array_values($query)); // its good enough

        if (Cache::has($cacheKey)) {
            $json = json_decode(Cache::get($cacheKey), true);
        } else {
            Log::info("Requesting from tetrio/$endpoint");
            $response = Http::tetrio()->timeout($maxTimeoutInSecs)->get($endpoint, $query);

            if ($response->failed()) {
                $status = $response->status();
                Log::error("Request to $cacheKey failed with status $status");
                return null;
            }

            $json = $response->json();

            if (!$json['success']) {
                $why = $json['error'];
                Log::error("Request to $cacheKey failed because '$why'");
                return null;
            }

            if ($cache) {
                // tetrio delivers caching data with every successful request https://tetr.io/about/api/#cachedata
                $cacheData = $json['cache'];
                $cachedUntil = Carbon::createFromTimestampMsUTC($cacheData['cached_until']);
                Cache::put($cacheKey, $response->body(), $cachedUntil);
                Log::info("Cached request data to $cacheKey until $cachedUntil");
            }

        }

        if ($json['data'] == null) return null;
        if ($defaultKey) return $json['data'][$defaultKey];
        return $json['data'];
    }

    public static function getServerStatistics()
    {
        // https://tetr.io/about/api/#generalstats
        return self::request('general/stats');
    }

    public static function getUserInfo(string $lookup)
    {
        // https://tetr.io/about/api/#usersuser
        return self::request("users/$lookup", [], 'user');
    }

    private static function getNewsStream(string $stream, int $limit = 25)
    {
        // https://tetr.io/about/api/#newsstream
        return self::request("news/$stream", ['limit' => $limit], 'news');
    }

    public static function getUserNewsStream(string $userId, int $limit = 25)
    {
        return self::getNewsStream("user_$userId", $limit);
    }

    public static function getGlobalNewsStream(int $limit = 25)
    {
        return self::getNewsStream('global', $limit);
    }

    public static function getFullLeaderboardExport()
    {
        // https://tetr.io/about/api/#userlistsleagueall
        return self::request("users/lists/league/all", [], 'users', true, 60 * 5);
    }

    public static function getUserFromDiscordId(string $id)
    {
        // https://tetr.io/about/api/#userssearchquery
        // don't cache, because this data will be accessed in real-time for connection
        return self::request("users/search/$id", [], 'user', false);
    }
}
