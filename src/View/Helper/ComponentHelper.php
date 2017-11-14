<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use Cake\View\Helper;
use OurSociety\View\Component\ComponentInterface;

class ComponentHelper extends Helper
{
    public function render(ComponentInterface $component, array $data = null): string
    {
        return $this->getView()->element(
            $this->getElementName($component),
            $this->getElementData($component, $data)
        );
    }

    private function getElementData(ComponentInterface $component, array $data = null): array
    {
        return [$this->getViewVariableName($component) => $component] + ($data ?? []);
    }

    private function getElementName(ComponentInterface $component): string
    {
        return $component->getElementName();
    }

    private function getViewVariableName(ComponentInterface $component): string
    {
        return $component->getViewVariableName();
    }
}
