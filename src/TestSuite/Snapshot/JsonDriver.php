<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Snapshot;

use PHPUnit\Framework\Assert;
use Spatie\Snapshots\Driver;

class JsonDriver implements Driver
{
    public function serialize($data): string
    {
        return json_encode($data);
    }

    public function extension(): string
    {
        return 'json';
    }

    public function match($expected, $actual): void
    {
        $expected = json_decode($expected, true);
        $actual = json_decode(json_encode($actual), true);

        Assert::assertEquals($expected, $actual);
    }
}
