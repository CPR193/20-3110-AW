<?php

/**
 * Bootstraop file which links the app path, settings path and then the settings themselves,
 * the dependencies file and the routes file.
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

session_start();

require 'vendor/autoload.php';

$app_path   = __DIR__ . '/app/';
$settings   = require $app_path . 'settings.php';
$container  = new \Slim\Container($settings);

require $app_path . 'dependencies.php';

$app = new \Slim\App($container);

require $app_path . 'routes.php';

$app->run();
