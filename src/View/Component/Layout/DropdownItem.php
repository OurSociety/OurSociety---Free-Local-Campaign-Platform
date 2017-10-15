<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

final class DropdownItem extends Link
{
    protected function getDefaultClasses(): array
    {
        return ['dropdown-item'];
    }
}
