<?php
declare(strict_types=1);

namespace OurSociety\View\Helper;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\View\View;

/**
 * PaginatorHelper.
 */
class PaginatorHelper extends BootstrapUI\PaginatorHelper
{
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        /** @noinspection HtmlUnknownTarget,UnknownInspectionInspection */
        $this->setConfig([
            'labels' => ['prev' => 'Previous', 'next' => 'Next'],
            'templates' => [
                'current' => '<li class="page-item active"><a class="page-link" href="">{{text}} <span class="sr-only">(current)</span></a></li>',
                'ellipsis' => '<li class="page-item ellipsis">&hellip;</li>',
                'first' => '<li class="page-item first"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'last' => '<li class="page-item last"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'nextActive' => '<li class="page-item"><a aria-label="Next" class="page-link" href="{{url}}">{{text}} &nbsp;<i class="fa fa-chevron-right"></i></a></li>',
                'nextDisabled' => '<li class="page-item disabled"><a aria-label="Next" class="page-link" href="{{url}}" tabindex="-1">{{text}} &nbsp;<i class="fa fa-chevron-right"></i></a></li>',
                'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}" aria-label="{{text}}"><i class="fa fa-chevron-left"></i>&nbsp; {{text}}</a></li>',
                'prevDisabled' => '<li class="page-item"><a class="page-link" href="{{url}}" aria-label="{{text}}"><i class="fa fa-chevron-left"></i>&nbsp; {{text}}</a></li>',
            ],
        ]);
    }

    public function prev($title = 'Previous', array $options = []): string
    {
        return parent::prev($title, $options);
    }

    public function next($title = 'Next', array $options = []): string
    {
        return parent::next($title, $options);
    }

    public function first($first = 'First', array $options = [])
    {
        return parent::first($first, $options);
    }

    public function last($last = 'Last', array $options = [])
    {
        return parent::last($last, $options);
    }

    /**
     * @param array|string $options
     * @return string
     */
    public function counter($options = []): string
    {
        if (is_string($options)) {
            $options = ['format' => $options];
        }

        $options += [
            'format' => __('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total'),
        ];

        return parent::counter($options);
    }
}
