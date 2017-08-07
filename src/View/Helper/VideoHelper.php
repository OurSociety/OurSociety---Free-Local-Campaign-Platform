<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use VideoEmbed\View\Helper as VideoEmbed;

class VideoHelper extends VideoEmbed\VideoHelper
{
    public function youtube($url, $settings = array())
    {
        $iframe = parent::youtube($url, $settings);

        if (isset($settings['class'])) {
            $iframe = str_replace('<iframe ', '<iframe class="' . $settings['class'] . '" ', $iframe);
        }

        return $iframe;
    }
}
