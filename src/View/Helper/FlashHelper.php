<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use OurSociety\View\AppView;

/**
 * FlashHelper.
 */
class FlashHelper extends BootstrapUI\FlashHelper
{
    public function __construct(AppView $View, array $config = [])
    {
        if ($View->getBootstrapVersion() === 4) {
            $config += ['class' => ['alert', 'alert-dismissible', 'fade', 'show']];
        }

        parent::__construct($View, $config);
    }
}
