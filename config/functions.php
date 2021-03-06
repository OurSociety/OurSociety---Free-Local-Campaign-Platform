<?php
declare(strict_types=1);

use Cake\View\Helper\UrlHelper;
use Cake\View\View;

if (!function_exists('dd')) {
    /** @noinspection PhpFunctionNamingConventionInspection */
    /**
     * Alias of Kint::dump(); die;
     *
     * @return string
     */
    function dd()
    {
        call_user_func_array(['Kint', 'dump'], func_get_args());
        die;
    }

    Kint::$aliases[] = 'dd';
}

if (!function_exists('mix')) {
    /** @noinspection PhpFunctionNamingConventionInspection */
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return string
     * @throws RuntimeException
     */
    function mix($path, $manifestDirectory = null)
    {
        static $manifests = [];

        if (strpos($path, '/') !== 0) {
            $path = "/{$path}";
        }

        if ($manifestDirectory && !strpos($manifestDirectory, '/') !== 0) {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        //if (file_exists(WWW_ROOT . $manifestDirectory.'/hot')) {
        if (file_exists(ROOT . 'hot')) {
            return "//localhost:8080{$path}";
        }

        $manifestPath = WWW_ROOT . $manifestDirectory . '/mix-manifest.json';
        if (!isset($manifests[$manifestPath])) {
            if (!file_exists($manifestPath)) {
                throw new RuntimeException('The Mix manifest does not exist.');
            }
            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];
        if (!isset($manifest[$path])) {
            throw new RuntimeException(
                "Unable to locate Mix file: {$path}. Please check your webpack.mix.js output paths and try again."
            );
        }

        $urlHelper = new UrlHelper(new View);

        return $urlHelper->assetUrl($manifestDirectory . $manifest[$path]);
    }
}
