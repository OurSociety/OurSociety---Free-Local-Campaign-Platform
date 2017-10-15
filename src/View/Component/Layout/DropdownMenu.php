<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

use OurSociety\View\Component\Component;

final class DropdownMenu extends Component
{
    /**
     * The name of the dropdown
     *
     * @var string
     **/
    protected $title;

    /**
     * Array of MenuDivider|MenuItem entries
     *
     * @var array
     **/
    protected $entries;

    /**
     * Contains an HTML link.
     *
     * @param string $title The name of the dropdown
     * @param array|null $entries Array of MenuDivider|MenuItem entries
     */
    public function __construct($title, array $entries = null)
    {
        $this->title = $title;
        $this->entries = $entries ?? [];
    }

    /**
     * Returns the menu item dropdown title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the menu item dropdown entries
     *
     * @return DropdownItem[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }
}
