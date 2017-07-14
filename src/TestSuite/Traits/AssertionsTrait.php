<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Traits;

use Cake\Chronos\ChronosInterface as Time;

trait AssertionsTrait
{
    protected static function assertTimeWithinLast(string $timeInterval, Time $time, ?string $message = null): void
    {
        self::assertTrue(
            $time->wasWithinLast($timeInterval),
            $message ?: sprintf(
                'Failed asserting that time "%s" was within last %s.',
                $time->toDateTimeString(),
                $timeInterval
            )
        );
    }
}
