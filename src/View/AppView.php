<?php
declare(strict_types=1);

namespace OurSociety\View;

use Cake\Core\Configure;
use CrudView\View as CrudView;
use Gourmet\KnpMenu\View\Helper as GourmetKnpMenu;

/**
 * Application view class.
 *
 * The application's default view class (based on CrudView) for handling HTML requests.
 *
 * @property Helper\BreadcrumbsHelper $Breadcrumbs
 * @property CrudView\Helper\CrudViewHelper $CrudView
 * @property Helper\FlashHelper $Flash
 * @property Helper\FormHelper $Form
 * @property Helper\HtmlHelper $Html
 * @property GourmetKnpMenu\MenuHelper $Menu
 * @property Helper\PaginatorHelper $Paginator
 * @property Helper\TagHelper $Tag
 * @property Helper\TimeHelper $Time
 * @property Helper\UrlHelper $Url
 * @property Helper\VideoHelper $Video
 */
class AppView extends CrudView\CrudView
{
    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        $this->_setupLayout();

        parent::initialize();
    }

    /**
     * Get Bootstrap version.
     *
     * Some helpers (such as Breadcrumbs, Form, etc.) switch templates based on the Bootstrap version.
     *
     * @return int The major version of Bootstrap.
     */
    public function getBootstrapVersion(): int
    {
        return ($this->isSite() || $this->isEmbed() || $this->isAdmin()) ? 4 : 3;
    }

    /**
     * Is admin?
     *
     * Determines if the current request is for an admin page, so layout settings can be switched.
     *
     * @return bool True if admin prefix, false otherwise.
     */
    public function isAdmin(): bool
    {
        return $this->request->getParam('prefix') === 'admin';
    }

    /**
     * Is embed?
     *
     * Determines if the current request is for an embedded widget, so layout settings can be switched.
     *
     * @return bool True if embed layout, false otherwise.
     */
    public function isEmbed(): bool
    {
        return $this->getLayout() === 'embed';
    }

    /**
     * {@inheritdoc}
     */
    protected function _loadAssets(): void
    {
        // Switch out default assets on embed layout.
        //if ($this->isSite()) {
        Configure::write('CrudView.css', [mix('css/site.css')]);
        Configure::write('CrudView.js.script', [
            mix('js/manifest.js'),
            mix('js/vendor.js'),
            mix('js/common.js'),
            mix('js/site.js'),
        ]);
        //}

        // Switch out default assets on embed layout.
        if ($this->isEmbed()) {
            Configure::write('CrudView.css', [mix('css/embed.css')]);
            Configure::write('CrudView.js.script', []); // NOTE: embed.js is outside the iframe, not inside.
        }

        // Switch out default assets on admin prefix.
        if ($this->isAdmin()) {
            $this->set(['containerClass' => 'container-fluid px-3 my-3']);
            Configure::write('CrudView.css', [mix('css/site.css'), mix('css/admin.css')]);
            Configure::write('CrudView.js.script', [
                mix('js/manifest.js'),
                mix('js/vendor.js'),
                mix('js/common.js'),
                mix('js/admin.js'),
                mix('js/site.js'),
            ]);
        }

        parent::_loadAssets();
    }

    /**
     * {@inheritdoc}
     */
    protected function _setupHelpers(): void
    {
        parent::_setupHelpers();

        // Unload helpers that CrudView loaded so we can use customised ones.
        $this->helpers()->unload('Breadcrumbs');
        $this->helpers()->unload('Flash');
        $this->helpers()->unload('Form');
        $this->helpers()->unload('Html');
        $this->helpers()->unload('Paginator');

        // These helpers override the CrudView ones with custom settings (thought they still extend BootstrapUI).
        $this->loadHelper('Breadcrumbs', ['className' => Helper\BreadcrumbsHelper::class]);
        $this->loadHelper('Flash', ['className' => Helper\FlashHelper::class]);
        $this->loadHelper('Form', ['className' => Helper\FormHelper::class]);
        $this->loadHelper('Html', ['className' => Helper\HtmlHelper::class]);
        $this->loadHelper('Paginator', ['className' => Helper\PaginatorHelper::class]);

        // Load extra helpers required by application.
        $this->loadHelper('Menu', ['className' => GourmetKnpMenu\MenuHelper::class]);
        $this->loadHelper('Video', ['className' => Helper\VideoHelper::class]);
    }

    /**
     * Setup layout.
     *
     * @return void
     */
    protected function _setupLayout(): void
    {
        // This check is so we don't break error pages by changing layout.
        if ($this->getLayout() !== 'CrudView.default') {
            return;
        }

        // Use the current prefixes default template, not the CrudView one.
        $this->setLayout('site');
    }

    /**
     * Setup paths.
     *
     * Add path with routing prefix so we can have custom scaffold templates for each one.
     *
     * @return void
     */
    protected function _setupPaths(): void
    {
        parent::_setupPaths();

        if ($this->isAdmin()) {
            Configure::write('App.paths.templates', array_merge(
                [APP . 'Template' . DS . 'Admin' . DS],
                Configure::read('App.paths.templates')
            ));
        }
    }

    /**
     * Is site?
     *
     * Determines if the current request is for a website page, so layout settings can be switched.
     *
     * @return bool True if website, false otherwise.
     */
    private function isSite(): bool
    {
        return $this->getLayout() === 'site';
    }
}
