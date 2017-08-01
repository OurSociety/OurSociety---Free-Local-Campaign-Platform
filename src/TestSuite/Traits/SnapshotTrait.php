<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Traits;

use OurSociety\TestSuite\Snapshot\JsonDriver;
use Spatie\Snapshots\MatchesSnapshots;

trait SnapshotTrait
{
    use MatchesSnapshots;

    public function assertSnapshot($actual): void
    {
        $this->assertMatchesSnapshot($actual, new JsonDriver);
    }
}
