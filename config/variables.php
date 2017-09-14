<?php
declare(strict_types=1);

use josegonzalez\Dotenv\Loader as Dotenv;

if (env('APP_NAME')) {
    return;
}

$filenames = [
    ROOT . DS . '.env',
    ROOT . DS . '.env.default',
];

foreach ($filenames as $filename) {
    if (!file_exists($filename)) {
        continue;
    }

    (new Dotenv($filename))->parse()->skipExisting()->toEnv();

    return;
}
