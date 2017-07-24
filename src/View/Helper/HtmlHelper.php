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

    public function dashboardLink(): string
    {
        [$prefix] = explode('/', $this->request->getParam('prefix'));

        return $this->link(
            __('{role} Dashboard', ['role' => ucfirst($prefix)]),
            ['_name' => sprintf('%s:dashboard', $prefix)
        ]);
    }

    public function politicianLink(User $politician, string $title = null, array $options = []): string
    {
        $title = $title ?: $politician->name;
        $url = ['_name' => 'citizen:politicians:view', 'slug' => $politician->slug];

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
}
