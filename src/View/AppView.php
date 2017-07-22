<?php
declare(strict_types = 1);

namespace OurSociety\View;

use BootstrapUI\View\Helper as BootstrapUI;
use CrudView\View\CrudView;
use CrudView\View\Widget as CrudViewWidget;
use OurSociety\View\Widget\EditorWidget;
use VideoEmbed\View\Helper as VideoEmbed;

/**
 * Application View
 *
 * Your application’s default view class, based on CrudView.
 *
 * @property BootstrapUI\FormHelper $Form
 * @property Helper\HtmlHelper $Html
 * @property Helper\UrlHelper $Url
 * @property VideoEmbed\VideoHelper $Video
 */
class AppView extends CrudView
{
    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        if ($this->layout() === 'CrudView.default') {
            $this->layout('site');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function _setupHelpers(): void
    {
        parent::_setupHelpers();

        $this->helpers()->unload('Html');
        $this->helpers()->unload('Form');

        $this->loadHelper('Html', ['className' => Helper\HtmlHelper::class]);
        $this->loadHelper('Form', ['className' => BootstrapUI\FormHelper::class, 'widgets' => [
            'editor' => [EditorWidget::class],
            // TODO: Implement better date/time widget with following requirements:
            // - Supports "date" also (not just "datetime"
            // - Easy to select DOB (a date many years in the past)
            // - Day field can be optional (for positions/qualifications/awards the day isn't important)
            //'datetime' => [CrudViewWidget\DateTimeWidget::class, 'select']
        ]]);
        $this->loadHelper('Video', ['className' => VideoEmbed\VideoHelper::class]);
    }
}
