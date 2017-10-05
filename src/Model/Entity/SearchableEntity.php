<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

interface SearchableEntity
{
    public function getKey(): string;

    public function searchableAs(): string;

    public function toSearchableArray(): array;
}
