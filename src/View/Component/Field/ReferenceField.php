<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use Cake\Log\LogTrait;
use OurSociety\Model\Entity\RecordInterface;
use Psr\Log\LogLevel;

final class ReferenceField extends Field
{
    use LogTrait;

    public function hasReference(): bool
    {
        try {
            $this->getReference();

            return true;
        } catch (\TypeError $typeError) {
            $this->log('Ignoring missing reference in reference field.', LogLevel::DEBUG, ['exception' => $typeError]);

            return false;
        }
    }

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
