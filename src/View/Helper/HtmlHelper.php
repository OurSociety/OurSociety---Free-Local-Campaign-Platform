<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper\OptionsAwareTrait;
use Cake\Log\Log;
use Cake\Routing\Exception\MissingRouteException;
use Cake\Utility\Inflector;
use LilHermit\Bootstrap4\View\Helper as Bootstrap4;
use OurSociety\Model\Entity\User;

/**
 * HtmlHelper.
 *
 * @property UrlHelper $Url
 */
class HtmlHelper extends Bootstrap4\HtmlHelper
{
    use OptionsAwareTrait;

    public function initialize(array $config): void
    {
        $this->helpers['Url'] = ['className' => UrlHelper::class];
    }

    public function dashboardLink(string $role = null, string $title = null, array $options = null): string
    {
        if ($role === null && $this->request->getParam('prefix') === false) {
            return $this->link(__($title ?: 'Home'), ['_name' => 'home'], $options ?? []);
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

    public function icon($name, array $options = null): string
    {
        $options = $options ?? [];
        $options += ['iconSet' => 'fa'];

        if ($options['iconSet'] === 'topic') {
            unset($options['iconSet']);

            return $this->tag('svg', $this->tag('use', '', [
                'xlink:href' => $this->Url->image(sprintf('icons-topics.svg#%s', $name)),
            ]), $options + ['class' => ['icon']]);
        }

        $options += [
            'tag' => 'i',
            'iconSet' => 'fa',
            'class' => null,
        ];

        $classes = [$options['iconSet'], $options['iconSet'] . '-' . $name];
        $options = $this->injectClasses($classes, $options);

        return $this->formatTemplate('tag', [
            'tag' => $options['tag'],
            'attrs' => $this->templater()->formatAttributes($options, ['tag', 'iconSet']),
        ]);
    }

    /**
     *
     *
     * @param array|string|User $path
     * @param array $options
     * @return string
     */
    public function image($path, array $options = []): string
    {
        if ($path instanceof User) {
            $user = $path;
            if ($user->picture === null) {
                $path = $user->level_badge_url;
            }
        }

        return parent::image($path, $options); // @todo Change the autogenerated stub
    }

    /**
     * @deprecated Use `$this->Html->badge()` instead.
     */
    public function label(string $text, $options = null): string
    {
        return $this->badge($text, $options);
    }

    /**
     * @param $text
     * @param array|string|null $options
     * @return string
     */
    public function badge(string $text, $options = null): string
    {
        $options = $options ?? [];

        if (is_string($options)) {
            $options = ['type' => $options];
        }

        $options += [
            'tag' => 'span',
            'type' => 'info',
        ];

        $classes = ['badge', 'badge-' . $options['type']];
        $tag = $options['tag'];
        unset($options['tag'], $options['type']);

        return $this->tag($tag, $text, $this->injectClasses($classes, $options));
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
     * @param string $template The template to use.
     * @param string $noun The noun to pluralize.
     * @param int $count The number to base pluralization off.
     * @param array $replacements Any additional replacements.
     * @return string
     */
    public function pluralize(string $template, string $noun, int $count, array $replacements = null): string
    {
        $one = 'one';
        $none = 'no';
        if (strpos($template, '{number}') === 0) {
            $one = ucfirst($one);
            $none = ucfirst($none);
        }

        return __n(
            __($template, ['number' => $one, 'noun' => $noun] + ($replacements ?? [])),
            __($template, ['number' => '{0}', 'noun' => Inflector::pluralize($noun)] + ($replacements ?? [])),
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

        $options = ['data-jdenticon-value' => $jdenticonValue] + $options + ['style' => 'background: white'];

        return $this->tag($tag, '', $options);
    }

    /**
     * Renders an email address.
     *
     * Outputs an email address in a way that should not be easily scraped by spam bots.
     *
     * @param string $email The email address.
     * @return string The obfuscated email link.
     */
    public function email(string $email, string $text = null, array $options = null): string
    {
        return $this->tag('span', strrev($email), ['style' => 'unicode-bidi: bidi-override; direction: rtl']);
    }
}
