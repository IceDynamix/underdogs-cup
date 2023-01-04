<?php

namespace App\Http\TetrioApi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\arrayHasKey;

class TetrioApi
{
    private static function request(string $endpoint, array $query = [])
    {
        $url = "https://ch.tetr.io/api/$endpoint";

        $cacheKey = 'tetrio/' . $endpoint . '?' . implode('&', array_values($query)); // its good enough

        $json = Cache::get($cacheKey);
        if (!empty($json))
            return json_decode($json, true);

        Log::info("Requesting from $url");
        $response = Http::get($url, $query);

        if ($response->failed()) {
            $status = $response->status();
            Log::error("Request to $url failed with status $status");
            return null;
        }

        $json = $response->json();

        if (!empty($json['error'])) {
            $why = $json['error'];
            Log::error("Request to $url failed because '$why'");
            return null;
        }

        // tetrio delivers caching data with every successful request https://tetr.io/about/api/#cachedata
        $cacheData = $json['cache'];
        $cachedUntil = Carbon::createFromTimestampMsUTC($cacheData['cached_until']);
        Cache::put($cacheKey, $response->body(), $cachedUntil);
        Log::info("Cached request data to $cacheKey until $cachedUntil");

        return $json['data'];
    }

    public static function getServerStatistics()
    {
        return self::request('general/stats');
    }
}
