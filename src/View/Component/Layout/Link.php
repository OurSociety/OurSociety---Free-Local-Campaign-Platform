<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Layout;

use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use OurSociety\View\Component\Component;

abstract class Link extends Component
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
    private $url;

    /**
     * Array of options and HTML attributes.
     *
     * @var array
     **/
    private $options;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * Contains an HTML link.
     *
     * @param string $title The content to be wrapped by `<a>` tags.
     * @param string|array|null $url Cake-relative URL or array of URL parameters, or
     *   external URL (starts with http://)
     * @param array|null $options Array of options and HTML attributes.
     */
    public function __construct($title, $url = null, array $options = null)
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
    public function getTitle(ServerRequest $request): string
    {
        if ($this->isActive($request)) {
            return $this->title . ' <span class="sr-only">(current)</span>';
        }

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

    /**
     * Returns the menu item options
     *
     * @return array
     */
    public function getOptions(ServerRequest $request): array
    {
        $options = $this->options ?? $this->getDefaultOptions();

        return $this->mergeClasses($options, $this->getClasses($request));
    }

    protected function getDefaultOptions(): array
    {
        return ['escape' => false];
    }

    abstract protected function getDefaultClasses(): array;

    private function isActive(ServerRequest $request): bool
    {
        if ($this->isActive !== null) {
            return $this->isActive;
        }

        $url = is_array($this->getUrl()) ? Router::reverse($this->getUrl()) : $this->getUrl();

        return $this->isActive = $url === $request->getUri()->getPath();
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
