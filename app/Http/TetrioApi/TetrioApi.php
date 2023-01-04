<?php

namespace App\Http\TetrioApi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TetrioApi
{
    private static function request(string $endpoint, array $query = [], ?string $defaultKey = null)
    {
        $cacheKey = 'tetrio/' . $endpoint . '?' . implode('&', array_values($query)); // its good enough

        $json = Cache::get($cacheKey);
        if (!empty($json))
            return json_decode($json, true);

        Log::info("Requesting from tetrio/$endpoint");
        $response = Http::tetrio()->get($endpoint, $query);

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

        // tetrio delivers caching data with every successful request https://tetr.io/about/api/#cachedata
        $cacheData = $json['cache'];
        $cachedUntil = Carbon::createFromTimestampMsUTC($cacheData['cached_until']);
        Cache::put($cacheKey, $response->body(), $cachedUntil);
        Log::info("Cached request data to $cacheKey until $cachedUntil");

        if ($defaultKey) {
            return $json['data'][$defaultKey];
        }

        return $json['data'];
    }

    public static function getServerStatistics()
    {
        // https://tetr.io/about/api/#generalstats
        return self::request('general/stats');
    }

    public static function getUserInfo(string $lookup) {
        // https://tetr.io/about/api/#usersuser
        return self::request("users/$lookup", [], 'user');
    }
}
