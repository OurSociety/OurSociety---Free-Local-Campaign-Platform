<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

use OurSociety\View\Component\Component;

class Icon extends Component
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
