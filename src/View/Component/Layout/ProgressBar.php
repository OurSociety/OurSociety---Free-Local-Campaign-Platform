<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

use OurSociety\View\Component\Component;

final class ProgressBar extends Component
{
    private $percentage;

    public function __construct(int $percentage)
    {
        $this->percentage = $percentage;
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }
}
