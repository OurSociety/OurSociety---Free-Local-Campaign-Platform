<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity\Traits;

trait SearchableTrait
{
    public function getKey(): string
    {
        return $this->id;
    }

    abstract public function searchableAs(): string;

    public function toSearchableArray(): array
    {
        return $this->toArray();
    }
}
