<?php
declare(strict_types=1);

namespace App\Service\Common\Clock;

use App\Core\Common\Clock;
use DateTimeImmutable;
use DateTimeInterface;

final class SystemClock implements Clock
{
    public function now(): DateTimeInterface
    {
        return new DateTimeImmutable();
    }
}
