<?php
/**
 * Page file that contains the form needed for sending telemetry data
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/sendSMS', function(Request $request, Response $response) use ($app) {
    $submit_button_text = 'Send SMS';
    $page_text = 'Enter a Message you\'d like to send and the Phone Number you\'d like to send it to';

    $html_output = $this->view->render($response,
    'sendSMSform.html.twig',
    [
        'css_path' => CSS_PATH,
        'landing_page' => LANDING_PAGE,
        'method' => 'post',
        'action' => 'sendSMSform',
        'initial_input_box_value' => null,
        'page_title' => APP_NAME,
        'page_heading_1' => APP_NAME,
        'page_heading_2' => 'Enter SMS details',
        'page_heading_3' => 'Telemetry Message Parameters',
        'submit_button_text' => $submit_button_text,
        'page_text' => $page_text
    ]);

    processOutput($app, $html_output);
    return $html_output;
})->setName('sendSMS');

