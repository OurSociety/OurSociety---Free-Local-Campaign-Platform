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

    protected $buttonUrl;

    protected $routeName;

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
        $defaultUrl = ['controller' => $this->getControllerName(), 'action' => $this->getActionName()];

        $url = $this->buttonUrl ?? $defaultUrl;
        if ($this->routeName !== null) {
            $url = ['_name' => $this->routeName];
        }

        $url[] = $this->getRecordIdentifier();

        return $url;
    }

    public function setButtonUrl(array $url): self
    {
        $this->buttonUrl = $url;

        return $this;
    }

    public function setRouteName($name): self
    {
        $this->routeName = $name;

        return $this;
    }

    abstract protected function getActionName(): string;

    protected function getControllerName(): string
    {
        return $this->getRecord()->getModelAlias();
    }

    protected function getRecordIdentifier(): string
    {
        return $this->getRecord()->getIdentifierValue();
    }
}
