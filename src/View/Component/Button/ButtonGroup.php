<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

use OurSociety\View\Component\Component;

class ButtonGroup extends Component
{
    /**
     * @var array
     */
    private $buttons;

    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }
}
