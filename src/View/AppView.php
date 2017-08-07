<?php
declare(strict_types = 1);

namespace OurSociety\View;

use BootstrapUI\View\Helper as BootstrapUI;
use Cake\Core\Configure;
use CrudView\View\CrudView;
use OurSociety\View\Widget\EditorWidget;
use OurSociety\View\Widget\ZipWidget;

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
        if ($this->layout() === 'embed') {
            Configure::write('CrudView.css', [mix('css/embed.css')]);
            Configure::write('CrudView.js.script', []); // NOTE: embed.js is outside the iframe, not inside.
        }

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
            'zip' => [ZipWidget::class, 'text'],
            // TODO: Implement better date/time widget with following requirements:
            // - Supports "date" also (not just "datetime"
            // - Easy to select DOB (a date many years in the past)
            // - Day field can be optional (for positions/qualifications/awards the day isn't important)
            //'datetime' => [CrudViewWidget\DateTimeWidget::class, 'select']
        ]]);
        $this->loadHelper('Video', ['className' => Helper\VideoHelper::class]);
    }
}
