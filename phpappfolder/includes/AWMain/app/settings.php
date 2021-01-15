<?php
/**
 * Settings declared
 *
 * @package AWMain
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'AWMain.%t');
ini_set('xdebug.trace_format', 1);

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$css_path = $app_url . '/css/style.css';
$log_file_path = 'p3t/phpappfolder/logs/';

define('CSS_PATH', $css_path);
define('APP_NAME', 'SMS thing (temp name)');
define('LANDING_PAGE', $app_url);
define('LOG_FILE_PATH', $log_file_path);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'class_path' => __DIR__ . '/src/',
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]
        ],
        'pdo_settings' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'sms_db',
            'port' => '3386',
            'user_name' => 'sms_user',
            'user_password' => 'sms_user_pass',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ],
    ],
];

return $settings;
