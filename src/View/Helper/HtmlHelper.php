<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\Log\Log;
use Cake\Routing\Exception\MissingRouteException;
use Cake\Utility\Inflector;
use Kminek\EmailObfuscator;
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

    public function dashboardLink(string $role = null, string $title = null, array $options = null): string
    {
        if ($role === null && $this->request->getParam('prefix') === false) {
            return $this->link(__($title ?: 'Home'), ['_name' => 'pages:home'], $options ?? []);
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

        return $this->link($title, ['_name' => $routeName], $options ?? []);
    }

    public function icon($name, array $options = []): string
    {
        if ($options['iconSet'] ?? null === 'topic') {
            unset($options['iconSet']);

            return $this->tag('svg', $this->tag('use', '', [
                'xlink:href' => $this->Url->image(sprintf('icons-topics.svg#%s', $name)),
            ]), $options + ['class' => ['icon']]);
        }

        return parent::icon($name, ['iconSet' => 'fa'] + $options);
    }

    public function image($path, array $options = []): string
    {
        if ($path instanceof User && $path->picture === null) {
            return $this->jdenticon($path->slug, $options);
        }

        return parent::image($path, $options); // @todo Change the autogenerated stub
    }

    public function label($text, $options = [])
    {
        return str_replace('label', 'badge', parent::label($text, $options));
    }

    /**
     * {@inheritdoc}
     *
     * @param string|array|null $url
     */
    public function link($title, $url = null, array $options = []): string
    {
        if (isset($options['icon'])) {
            $title = $this->icon($options['icon'], ['class' => ['fa-fw']]) . ' ' . $title;
            $options['escape'] = false;
            unset($options['icon']);
        }

        try {
            return parent::link($title, $url, $options);
        } catch (MissingRouteException $exception) {
            Log::warning(sprintf('Missing link "%s": %s', $title, is_array($url) ? json_encode($url) : $url));
            return '';
        }
    }

    public function politicianLink(User $politician, ?string $title = null, ?array $options = null): string
    {
        $title = $title ?: $politician->name;
        $url = ['_name' => 'politician', 'politician' => $politician->slug];

        $options = $options ?? [];
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
        $one = 'one';
        $none = 'no';
        if (strpos($template, '{number}') === 0) {
            $one = ucfirst($one);
            $none = ucfirst($none);
        }

        return __n(
            __($template, ['number' => $one, 'noun' => $noun]),
            __($template, ['number' => '{0}', 'noun' => Inflector::pluralize($noun)]),
            $count,
            $count === 0 ? $none : $count
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
    public function jdenticon(string $jdenticonValue, ?array $options = null, ?string $tag = null): string
    {
        $options = $options ?? [];
        $tag = $tag ?? 'svg';

        return $this->tag($tag, '', ['data-jdenticon-value' => $jdenticonValue] + $options + [
            'style' => 'background: white'
        ]);
    }

    /**
     * Renders an email address.
     *
     * Outputs an email address in a way that should not be easily scraped by spam bots.
     *
     * @param string $email The email address.
     * @return string The obfuscated email link.
     */
    public function email(string $email): string
    {
        return EmailObfuscator::obfuscate($email);
    }
}
