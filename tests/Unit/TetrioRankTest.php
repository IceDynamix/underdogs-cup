<?php

namespace Tests\Unit;

use App\Enums\TetrioRank;
use PHPUnit\Framework\TestCase;

class TetrioRankTest extends TestCase
{
    public function testRankComparison()
    {
        $this->assertEquals(-1, TetrioRank::Unranked->rank());
        $this->assertGreaterThan(TetrioRank::AMinus->rank(), TetrioRank::A->rank());
    }
}
