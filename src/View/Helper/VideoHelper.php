<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use VideoEmbed\View\Helper as VideoEmbed;

/**
 * Video helper.
 *
 * @property HtmlHelper $Html
 */
class VideoHelper extends VideoEmbed\VideoHelper
{
    public $helpers = [
        'Html' => ['className' => HtmlHelper::class],
    ];

    public function youtube($url, $settings = []): string
    {
        $settings += [
            'iframeClass' => ['embed-responsive-item'],
            'failSilently' => true,
            'wrapperClass' => ['embed-responsive', 'embed-responsive-16by9'],
        ];

        $iframe = parent::youtube($url, $settings);

        if (isset($settings['iframeClass'])) {
            if (is_array($settings['iframeClass'])) {
                $settings['iframeClass'] = implode(' ', $settings['iframeClass']);
            }
            $iframe = str_replace('<iframe ', '<iframe class="' . $settings['iframeClass'] . '" ', $iframe);
        }

        $iframe = str_replace('?', '?enablejsapi=1&amp;', $iframe);

        return $this->Html->div($settings['wrapperClass'], $iframe);
    }
}
