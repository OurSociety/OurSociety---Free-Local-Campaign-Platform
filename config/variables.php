<?php
declare(strict_types=1);

use josegonzalez\Dotenv\Loader as Dotenv;

$filenames = [
    DS . 'var' . DS . 'run' . DS . 'secret' . DS . 'env', // /var/run/secret/env
    ROOT . DS . '.env',                                   // ./.env
    ROOT . DS . '.env.dist',                              // ./.env.dist
];

foreach ($filenames as $filename) {
    if (!file_exists($filename)) {
        continue;
    }

    (new Dotenv($filename))->parse()->skipExisting()->toEnv();

    return;
}
