<?php
declare(strict_types = 1);

use Cake\Core\Configure;
use Cake\Mailer\Email;
use OurSociety\Mailer\Transport\TestTransport;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

/**
 * Override some configuration values for testing.
 *
 * - Debug off so assertions can be performed on error pages.
 * - Full base URL set to a known value for testing URLs in emails.
 */
Configure::write('debug', 0);
Configure::write('App.fullBaseUrl', 'https://test.oursociety.org');

/**
 * Change default email transport to one suitable for tests.
 */
Email::dropTransport('default');
Email::setConfigTransport('default', ['className' => TestTransport::class]);

/**
 * Kint debugger customisations.
 */
Kint::$enabled_mode = true;

/**
 * Seed for predictable randomness during testing.
 */
define('SEED', 42);
