<?php
/** Send SMS result page
 *
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/sendSMSform', function (Request $request, Response $response) use ($app) {
    $tainted_param = $request ->getParsedBody();
    $send_sms = sendSMS($app, $tainted_param);
    $submit_button_text = 'Back';

    $html_output = $this->view->render($response,
    'sendSMSresultform.html.twig',
    [
        'css_path' => CSS_PATH,
        'landing_page' => LANDING_PAGE,
        'method' => 'get',
        'action' => 'sendSMS',
        'page_heading_1' => APP_NAME,
        'page_heading_2' => 'The following message has been sent',
        'send_sms' => $send_sms,
        'submit_button_text' => $submit_button_text,
        'page_text' => null
    ]);

    processOutput($app, $html_output);
    return $html_output;
})->setName('sendSMSform');

function sendSMS($app, $send_param) {
    $send_result = [];

    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $soap_client = $soap_wrapper->createSoapClient();
    $soap_model = $app->getContainer()->get('m2mSoapModel');

    if (is_object($soap_client)) {
        try {
            $soap_model->setSoapWrapper($soap_wrapper);
            $soap_model->deliverSMS($send_param);

            $send_result = $soap_model->getResult();
        }
        catch (\SoapFault $exception) {
            $send_result = $exception;
        }
    }

    return $send_result;
}