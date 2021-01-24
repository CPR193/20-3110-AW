<?php
/**
 * Page file containing the form needed to download messages through the SOAP client
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/downloadSMS', function(Request $request, Response $response) use ($app) {
    $submit_button_text = 'Download SMS';
    $page_text_1 = "Enter EE Login and Number of Messages You'd Like to Retrieve:";

    $html_output = $this->view->render($response,
    'downloadSMSform.html.twig',
    [
       'css_path' => CSS_PATH,
       'landing_page' => LANDING_PAGE,
       'method' => 'post',
       'action' => 'downloadSMSresult',
       'initial_input_box_value' => null,
       'page_title' => APP_NAME,
       'page_heading_1' => APP_NAME,
       'page_heading_2' => 'Enter SMS Download Details',
       'submit_button_text' => $submit_button_text,
       'page_text_1' => $page_text_1
    ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('downloadSMS');