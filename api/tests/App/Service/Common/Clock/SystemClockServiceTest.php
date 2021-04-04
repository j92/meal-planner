<?php
declare(strict_types=1);

namespace App\Service\Common\Clock;

use PHPUnit\Framework\TestCase;

class SystemClockServiceTest extends TestCase
{
    public function testReturnsNewDateEveryTime(): void
    {
        $clock = new SystemClock();

        $one = $clock->now();
        $two = $clock->now();

        self::assertNotSame($one, $two);
    }
}
