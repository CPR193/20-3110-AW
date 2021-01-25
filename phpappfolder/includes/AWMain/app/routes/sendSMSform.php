<?php
/**
 * Page file that contains the results of the send SMS page
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->post('/sendSMSform', function (Request $request, Response $response) use ($app) {
    $tainted_param = $request ->getParsedBody();
    $cleaned_param = sendDataValidator($app, $tainted_param);
    $send_sms = sendSMS($app, $cleaned_param);
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

/**
 * Function that sends a message containing the telemetry data supplied by the send SMS page
 *
 * @param $app - variable containing the application data used to get M2MSoapModel and SOAP Wrapper functions
 * @param $send_param - variable containing parameters from the send SMS page
 * @return Exception|SoapFault|null - exception thrown when invalid data has been supplied
 */
function sendSMS($app, $send_param) {
    $send_result = null;

    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $soap_client = $soap_wrapper->createSoapClient();
    $soap_model = $app->getContainer()->get('m2mSoapModel');
    $logger = $app->getContainer()->get('logger');
    $logger->pushHandler(new StreamHandler(LOG_FILE, Logger::WARNING));

    if (is_object($soap_client)) {
        try {
            $soap_model->setSoapWrapper($soap_wrapper);
            $soap_model->deliverSMS($send_param);

            $send_result = $soap_model->getResult();

        }
        catch (\SoapFault $exception) {
            $send_result = $exception;
            $logger->error($exception);
        }
    }
    return $send_result;
}

/**
 * Function that validates the raw parameters from the send SMS page in order to be sent
 *
 * @param $app - variable containing the application data used to get Validator functions
 * @param $tainted_param - variable containing the raw parameters of the send SMS page
 * @return array - array containing clean parameters ready for sending
 */
function sendDataValidator($app, $tainted_param) {
    $clean_param = null;

    $validator = $app->getContainer()->get('validator');
    $clean_param = $validator->validateSendData($tainted_param);

    return $clean_param;
}