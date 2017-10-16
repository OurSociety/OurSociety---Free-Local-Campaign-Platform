<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\View\View;

/**
 * BreadcrumbsHelper.
 *
 * @property UrlHelper $Url
 */
class BreadcrumbsHelper extends BootstrapUI\BreadcrumbsHelper
{
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        $this->setConfig('templates', [
            'wrapper' => '<nav class="breadcrumb" aria-label="Breadcrumb" {{attrs}}>{{content}}</nav>',
            'item' => '<a class="breadcrumb-item" href="{{url}}" {{attrs}} {{innerAttrs}}>{{title}}</a>',
            'itemWithoutLink' => '<a class="breadcrumb-item active" aria-current="page" {{attrs}} {{innerAttrs}}>{{title}}</a>',
        ]);
    }
}
