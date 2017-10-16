<?php
declare(strict_types=1);

namespace OurSociety\View\Tag\Menu;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use OurSociety\View\Tag\Tag;

final class DropdownItem extends Tag
{
    /**
     * The content to be wrapped by `<a>` tags.
     *
     * @var string
     **/
    private $title;

    /**
     * Cake-relative URL or array of URL parameters, or
     * external URL (starts with http://)
     *
     * @var string|array|null
     */
    private $url = null;

    /**
     * Array of options and HTML attributes.
     *
     * @var array
     **/
    private $options = [];

    /**
     * Contains an HTML link.
     *
     * @param string $title The content to be wrapped by `<a>` tags.
     * @param string|array|null $url Cake-relative URL or array of URL parameters, or
     *   external URL (starts with http://)
     * @param array $options Array of options and HTML attributes.
     */
    public function __construct($title, $url = null, array $options = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->options = $options;
    }

    /**
     * Returns the menu item title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the menu item ur
     *
     * @return string|array|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getElement(): string
    {
        return 'Tag/Menu/DropdownItem';
    }

    /**
     * Returns the menu item options
     *
     * @return array
     */
    public function getOptions(ServerRequest $request): array
    {
        return $this->mergeClasses($this->options, $this->getClasses($request));
    }

    private function getDefaultClasses(): array
    {
        return ['dropdown-item'];
    }

    private function isActive(ServerRequest $request): bool
    {
        return $request->getUri()->getPath() === (is_array($this->getUrl()) ? Router::reverse($this->getUrl()) : $this->getUrl());
    }

    private function getActiveClasses(): array
    {
        return ['active'];
    }

    private function getClasses(ServerRequest $request): array
    {
        $classes = $this->getDefaultClasses();

        if ($this->isActive($request)) {
            $classes = array_merge($classes, $this->getActiveClasses());
        }

        return $classes;
    }
}
