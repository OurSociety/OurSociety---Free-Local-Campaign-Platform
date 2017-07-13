<?php
declare(strict_types = 1);

namespace OurSociety\Utility;

use League\Csv\Reader;

final class Csv
{
    private function __construct(string $filename, ?Reader $reader = null)
    {
        $this->reader = $reader ?: Reader::createFromPath($filename);
    }

    public static function fromFile(string $filename, ?Reader $reader = null): self
    {
        return new self($filename, $reader);
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->reader->setHeaderOffset(0)->getRecords() as $record) {
            $array[] = $record;
        }

        return $array;
    }
}
