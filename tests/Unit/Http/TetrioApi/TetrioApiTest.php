<?php

namespace Http\TetrioApi;

use App\Http\TetrioApi\TetrioApi;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TetrioApiTest extends TestCase
{
    public function testRequestConnection() {
        $this->assertNotNull(TetrioApi::getServerStatistics());
    }

    public function testRequestCache() {
        $key = 'tetrio/general/stats?';
        Cache::forget($key);
        $this->assertNotNull(TetrioApi::getServerStatistics());
        $this->assertTrue(Cache::has($key));
    }
}
