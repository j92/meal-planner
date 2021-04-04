<?php
declare(strict_types=1);

namespace App\Core\Common;

interface Clock
{
    public function now(): \DateTimeInterface;
}
