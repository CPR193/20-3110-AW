<?php
/**
 * Settings file which declares and stores app settings
 *
 * @package AWMain
 * @author  20-3110-AW - Cosmin
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'AWMain.%t');
ini_set('xdebug.trace_format', 1);

define('DIRSEP', DIRECTORY_SEPARATOR);

$app_url = $css_path = $_SERVER['SCRIPT_NAME'];
$app_url = implode('/',explode('/', $app_url, -1));
$css_path = $app_url . '/css/style.css';
$log_file_path = '/logs/';
$log_file_name = 'AWMain_log.log';
$log_file = $log_file_path.$log_file_name;

$script_filename = $_SERVER["SCRIPT_FILENAME"];
$arr_script_filename = explode('/', $script_filename, '-1');
$script_path = implode('/', $arr_script_filename) . '/';

$wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';

define('CSS_PATH', $css_path);
define('APP_NAME', 'AW SMS M2M APP');
define('LANDING_PAGE', $app_url);
define('LOG_FILE_PATH', $log_file_path);
define('LOG_FILE_NAME', $log_file_name);
define('LOG_FILE', $log_file);

define ('SMS_OUTPUT_PATH', 'media/SMS/');
define ('SMS_FILE_PATH', $script_path);

define('WSDL', $wsdl);

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
        'doctrine_settings' => [
            'driver' => 'pdo_mysql',
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
