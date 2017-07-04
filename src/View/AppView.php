<?php
declare(strict_types = 1);

namespace OurSociety\View;

use Cake\Core\Configure;
use CrudView\View\CrudView;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends CrudView
{
    /**
     * Stylesheets.
     *
     * @var array The list of stylesheets.
     */
    private static $stylesheets = [
        'https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/journal/bootstrap.min.css',
        'app', // webroot/css/app.css
    ];

    /**
     * Scripts.
     *
     * @var array The list of scripts, with the name of each script block as the key and the list of scripts to appear
     *   in that block as the value.
     */
    private static $scripts = [
        'headjs' => [],
        'script' => ['app'], // webroot/js/app.css
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->layout = 'site';
    }

    /**
     * {@inheritdoc}
     */
    protected function _loadAssets(): void
    {
        parent::_loadAssets();

        $this->_loadStylesheets();
        $this->_loadScripts();
    }

    /**
     * Load stylesheets.
     *
     * Appends each stylesheet in the property above to the view block in the header of the HTML layout.
     *
     * @return void
     */
    protected function _loadStylesheets(): void
    {
        foreach (self::$stylesheets as $stylesheet) {
            $this->_loadAsset('css', $stylesheet);
        }
    }

    /**
     * Load scripts.
     *
     * Appends the scripts in the property above to the view blocks in the header (headjs) or bottom (script) of the
     * HTML layout.
     *
     * @return void
     */
    protected function _loadScripts(): void
    {
        foreach (self::$scripts as $block => $scripts) {
            $this->_loadAsset('script', $scripts, $block);
        }
    }

    /**
     * Load asset.
     *
     * Appends a single asset (stylesheet/script) to a view block using the core HTML helper or the AssetCompress plugin
     * if available.
     *
     * @param string $type The type of asset ('css' or 'script').
     * @param string|string[] $asset The asset or list of assets.
     * @param bool $block The view block to append asset to.
     * @return void
     */
    protected function _loadAsset(string $type, $asset, $block = true): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Configure::read('CrudView.useAssetCompress')
            ? $this->AssetCompress->{$type}($asset, ['block' => $block])
            : $this->Html->{$type}($asset, ['block' => $block]);
    }
}
