<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

final class NavLink extends Link
{
    protected function getDefaultClasses(): array
    {
        return ['nav-link'];
    }
}
