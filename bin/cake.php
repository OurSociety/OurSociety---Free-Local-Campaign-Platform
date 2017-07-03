#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
 */

$minVersion = '5.6.0';
if (file_exists('composer.json')) {
    $composer = json_decode(file_get_contents('composer.json'));
    if (isset($composer->require->php)) {
        $minVersion = preg_replace('/([^0-9\.])/', '', $composer->require->php);
    }
}
if (version_compare(phpversion(), $minVersion, '<')) {
    fwrite(STDERR, sprintf("Minimum PHP version: %s. You are using: %s.\n", $minVersion, phpversion()));
    exit(-1);
}

require dirname(__DIR__) . '/vendor/autoload.php';
include dirname(__DIR__) . '/config/bootstrap.php';

exit(Cake\Console\ShellDispatcher::run($argv));
