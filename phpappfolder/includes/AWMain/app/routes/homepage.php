<?php
/**
 * Home page of the application
 *
 * @package AWMain
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app) {

    $html_output = $this->view->render($response,
    'homepageform.html.twig',
    [
        'css_path' => CSS_PATH,
        'landing_page' => LANDING_PAGE,
        'method' => 'get',
        'action' => 'index.php',
        'page_title' => APP_NAME,
        'page_heading_1' => '20-3110-SW | M2M SMS',
        'page_text' => '',
        'send_sms' => LANDING_PAGE . '/sendSMS',
        'download_sms' => LANDING_PAGE . '/downloadSMS'
    ]);

    processOutput($app, $html_output);
    return $html_output;

})->setName('homepage');

function processOutput($app, $html_output) {
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}