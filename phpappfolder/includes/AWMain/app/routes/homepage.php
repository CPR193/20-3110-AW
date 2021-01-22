<?php
/**
 * Home page of the application
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app) {

    $sms_test = retrieveSMSTest($app);

    $html_output = $this->view->render($response,
    'homepageform.html.twig',
    [
        'css_path' => CSS_PATH,
        'landing_page' => LANDING_PAGE,
        'method' => 'get',
        'action' => 'index.php',
        'page_title' => APP_NAME,
        'page_heading_1' => 'Hello yes, this is 20-3110-AW. :)',
        'page_text' => 'Hello world or something, IDK I\'m not a computer. Please give us extension!',
        'send_sms' => LANDING_PAGE . '/sendSMS',
        'download_sms' => LANDING_PAGE . '/downloadSMS',
        'sms_test' => $sms_test
    ]);

    processOutput($app, $html_output);
    return $html_output;

})->setName('homepage');

function processOutput($app, $html_output) {
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}

function retrieveSMSTest($app) {
    $test_result = [];
    $soap_wrapper = $app->getContainer()->get('soapWrapper');

    $soap_model = $app->getContainer()->get('m2mSoapModel');
    $soap_model->setSoapWrapper($soap_wrapper);

    $soap_model->retrieveSMS();
    $test_result = $soap_model->getResult();

    return $test_result;
}