<?php
declare(strict_types=1);

namespace OurSociety\View\Component;

use OurSociety\View\Component\Button\Button;
use OurSociety\View\Component\Button\ButtonGroup;
use OurSociety\View\Component\Button\RecordButton;
use OurSociety\View\Component\Button\RepositoryButton;
use OurSociety\View\Component\Field\Field;
use OurSociety\View\Component\Field\FieldList;

trait NestedComponentAwareTrait
{
    private $components;

    /**
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @return FieldList|Field[]
     */
    public function getFields(): FieldList
    {
        $isField = function (Component $component) {
            return $component instanceof Field;
        };

        $fields = collection($this->components)->filter($isField)->toList();

        return $fields !== null ? new FieldList($fields) : $this->getDefaultFields();
    }

    /**
     * @return RecordButton[]
     */
    public function getRecordButtons(): array
    {
        return $this->getButtonsMatchingScope(Button::SCOPE_RECORD);
    }

    /**
     * @return RepositoryButton[]
     */
    public function getRepositoryButtons(): array
    {
        return $this->getButtonsMatchingScope(Button::SCOPE_REPOSITORY);
    }

    public function getButtonGroup(string $scope = null): ButtonGroup
    {
        $decorateRepositoryButtons = function (Button $button): Button {
            if ($button instanceof RepositoryButton) {
                return $button->withRepository($this->getRepositoryName());
            }

            return $button;
        };

        $decorateRecordButtons = function (Button $button): Button {
            if ($button instanceof RecordButton) {
                return $button->withRecord($this->getRecord());
            }

            return $button;
        };

        $buttons = collection($this->getButtonsMatchingScope($scope))
            ->map($decorateRepositoryButtons)
            ->map($decorateRecordButtons)
            ->toList();

        return new ButtonGroup($buttons);
    }

    abstract protected function getDefaultFields(): FieldList;

    /**
     * @return RepositoryButton[]
     */
    private function getButtonsMatchingScope(string $scope = null): array
    {
        $buttonMatchesScope = function (Button $button) use ($scope) {
            return $button->hasButtonScope($scope);
        };

        return collection($this->getButtons())->filter($buttonMatchesScope)->toList();
    }

    private function setComponents(array $components): void
    {
        if (count($components) === 0) {
            throw new \InvalidArgumentException('Expected at least one nested component to render.');
        }

        $this->components = $components;
    }

    /**
     * @param string|null $scope
     * @return Button[]|RecordButton[]
     */
    private function getButtons(string $scope = null): array
    {
        $isButton = function (Component $component) {
            return $component instanceof Button;
        };

        return collection($this->components)->filter($isButton)->toList();
    }
}
