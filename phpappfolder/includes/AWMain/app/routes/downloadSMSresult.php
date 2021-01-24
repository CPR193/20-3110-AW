<?php
/**
 * Page file that contains the results of the download SMS page
 *
 * @package AWMain
 * @Author 20-3110-AW - Cosmin
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/downloadSMSresult', function(Request $request, Response $response) use ($app) {

    $tainted_param = $request->getParsedBody();
    $dl_sms = downloadSMS($app, $tainted_param);
    $submit_button_text = 'Back';

    $html_output = $this->view->render($response,
        'downloadSMSresultform.html.twig',
        [
         'css_path' => CSS_PATH,
         'landing_page' => LANDING_PAGE,
         'method' => 'get',
         'action' => 'downloadSMS',
         'page_title' => APP_NAME,
         'page_heading_1' => APP_NAME,
         'page_heading_2' =>'These Messages have been Downloaded',
         'dl_sms' => $dl_sms,
         'submit_button_text' => $submit_button_text,
         'page_text' => null
        ]);
    processOutput($app, $html_output);

    return $html_output;
})->setName('downloadSMSresult');


/**
 * Function that downloads a number of messages through the SOAP client based on the form of the download SMS page
 *
 * @param $app - variable containing the application data used to get M2MSoapModel and SOAP Wrapper functions
 * @param $dl_param - variable containing parameters needed for the SOAP client web-function call
 * @return array|Exception|SoapFault - array containing SOAP client errors
 */
function downloadSMS($app, $dl_param) {
    $dl_result = [];

    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $soap_client = $soap_wrapper->createSoapClient();
    $soap_model = $app->getContainer()->get('m2mSoapModel');

    if (is_object($soap_client)) {
        try {
            $soap_model->setSoapWrapper($soap_wrapper);
            $soap_model->retrieveSMS($dl_param);

            $dl_result = $soap_model->getResult();
        }
        catch (\SoapFault $exception) {
            $dl_result = $exception;
        }
    }

    return $dl_result;
}

function parseSMS($app, $dl_sms) {
    $parse_result = null;

    $xml_parser = $app->getContainer()->get('xmlParser');
    $xml_parser->setXmlStringToParse($dl_sms);
    $xml_parser->parseTheXmlString();

    $parse_result = $xml_parser->getParsedData();

    return $parse_result;
}