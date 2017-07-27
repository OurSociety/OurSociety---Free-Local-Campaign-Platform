<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\Utility\Inflector;
use OurSociety\Model\Entity\User;

/**
 * HtmlHelper.
 *
 * @property UrlHelper $Url
 */
class HtmlHelper extends BootstrapUI\HtmlHelper
{
    public function initialize(array $config): void
    {
        $this->helpers['Url'] = ['className' => UrlHelper::class];
    }

    public function gravatar(string $email, ?array $options = []): string
    {
        $url = $this->Url->gravatarUrl($email, $options['defaults'] ?? []);

        return $this->image($url, $options);
    }

    public function dashboardLink(string $role = null, string $title = null): string
    {
        if ($role === null && $this->request->getParam('prefix') === false) {
            return $this->link(__($title ?: 'Home'), ['_name' => 'pages:home']);
        }

        if ($role === null) {
            switch ($this->request->getParam('prefix')) {
                case 'citizen':
                    $role = User::ROLE_CITIZEN;
                    break;
                case 'politician':
                case 'politician/profile':
                    $role = User::ROLE_POLITICIAN;
                    break;
                case 'admin':
                    $role = User::ROLE_ADMIN;
            }
        }

        if ($title === null) {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $title = $role === null
                ? __('Home')
                : __('{role} Dashboard', ['role' => ucfirst($role)]);
        }
        $routeName = sprintf('%s:dashboard', $role);

        return $this->link($title, ['_name' => $routeName]);
    }

    public function politicianLink(User $politician, string $title = null, array $options = []): string
    {
        $title = $title ?: $politician->name;
        $url = ['_name' => 'politician', 'politician' => $politician->slug];

        if (isset($options['#'])) {
            $url['#'] = $options['#'];
            unset($options['#']);
        }

        return $this->link($title, $url, $options);
    }

    /**
     * Pluralize.
     *
     * Helper method for translating templates like "{number} {noun} clicked." to:
     *
     * - "No things clicked."
     * - "One thing clicked."
     * - "2 things clicked."
     *
     * @param string $template
     * @param string $noun
     * @param int $count
     * @return string
     */
    public function pluralize(string $template, string $noun, int $count): string
    {
        return __n(
            __($template, ['number' => 'One', 'noun' => $noun]),
            __($template, ['number' => '{0}', 'noun' => Inflector::pluralize($noun)]),
            $count,
            $count === 0 ? 'No' : $count
        );
    }

    /**
     * Renders a jdenticon.
     *
     * @link https://jdenticon.com/
     * @param string $jdenticonValue The string unique to the user/entity you are displaying jdenticon for.
     * @param array|null $options The list of options for the tag.
     * @param string|null $tag The tag to use ('svg' for vector, or 'canvas' for raster/PNG).
     * @return string The tag where jdenticon will be rendered.
     */
    public function jdenticon(string $jdenticonValue, ?array $options = [], ?string $tag = null): string
    {
        return $this->tag($tag ?: 'svg', '', ['data-jdenticon-value' => $jdenticonValue] + $options);
    }
}
