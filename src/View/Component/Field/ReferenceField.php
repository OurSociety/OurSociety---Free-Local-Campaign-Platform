<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use OurSociety\Model\Entity\RecordInterface;

final class ReferenceField extends Field
{
    /**
     * Get reference title.
     *
     * @return string The display value of referenced record.
     */
    public function getReferenceTitle(): string
    {
        return $this->getReference()->getDisplayValue();
    }

    /**
     * Get reference URL.
     *
     * @return array The URL for viewing the referenced record.
     */
    public function getReferenceUrl(): array
    {
        return [
            'controller' => $this->getReference()->getModelAlias(),
            'action' => 'view',
            $this->getReference()->getIdentifierValue(),
        ];
    }

    public function getReferenceIcon(): string
    {
        return $this->getReference()->getIcon();
    }

    /**
     * Get reference.
     *
     * @return RecordInterface The referenced record.
     */
    private function getReference(): RecordInterface
    {
        return $this->getValue();
    }
}
