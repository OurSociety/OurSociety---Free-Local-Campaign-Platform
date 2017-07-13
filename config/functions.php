<?php
declare(strict_types=1);

if (!function_exists('dd')) {
    /**
     * Alias of Kint::dump(); die;
     *
     * @return string
     */
    function dd()
    {
        call_user_func_array(array('Kint', 'dump'), func_get_args());
        die;
    }

    Kint::$aliases[] = 'dd';
}
