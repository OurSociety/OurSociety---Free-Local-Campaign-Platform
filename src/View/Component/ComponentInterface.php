<?php
declare(strict_types=1);

namespace OurSociety\View\Component;

interface ComponentInterface
{
    public function getElementName(): string;

    public function getViewVariableName(): string;
}
