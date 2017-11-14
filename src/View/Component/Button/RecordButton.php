<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\Component\RecordAwareTrait;

/**
 * Record button.
 *
 * Buttons that are scoped to/act on a single record.
 */
abstract class RecordButton extends Button
{
    use RecordAwareTrait;

    public function __construct(RecordInterface $record = null)
    {
        $this->setRecord($record);
    }

    public function getButtonScope(): string
    {
        return self::SCOPE_RECORD;
    }

    public function getButtonUrl(): array
    {
        return [
            'controller' => $this->getControllerName(),
            'action' => $this->getActionName(),
            $this->getIdentifier(),
        ];
    }

    abstract protected function getActionName(): string;

    protected function getControllerName(): string
    {
        return $this->getRecord()->getModelAlias();
    }

    private function getIdentifier(): string
    {
        return $this->getRecord()->getIdentifierValue();
    }
}
