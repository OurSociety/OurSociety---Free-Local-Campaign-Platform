<?php
declare(strict_types=1);

use josegonzalez\Dotenv\Loader as Dotenv;

// Exit if configuration already exists (e.g. passed in from web server):
if (env('APP_NAME')) {
    return;
}

// Order of precedence (from highest to lowest):
$filenames = [
    ROOT . DS . '.env.test', // Overridden settings during test runs take highest precedence.
    ROOT . DS . '.env', // Next we use any custom settings that have been set for current environment.
    ROOT . DS . '.env.default', // Finally we fall back to default settings in the template file.
];

// Try to load each file in turn:
foreach ($filenames as $filename) {
    // Ignore/skip missing files:
    if (!file_exists($filename)) {
        continue;
    }

    // Load env file, skipping any variables that have been set already:
    (new Dotenv($filename))->parse()->skipExisting()->toEnv();
}
