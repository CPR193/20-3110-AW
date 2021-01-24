<?php
/**
 * Wrapper Class for communicating to a web-service via a SOAP client
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

namespace AWMain;

class SoapWrapper
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Function that creates a SOAP client instance
     *
     * @return \SoapClient|string - object containing SOAP client information
     * @return \Exception|\SoapFault|string - exception thrown when unable to connect to wsdl
     */

    public function createSoapClient() {
        $soap_client_handle = false;
        $soap_client_parameters = array();
        $exception = '';
        $wsdl = WSDL;

        $soap_client_parameters = ['trace' => true, 'exceptions' => true];
        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);

        }
        catch (\SoapFault $exception) {
            $soap_client_handle = 'Something went wrong connecting to the data supplier!';
        }
        return $soap_client_handle;
    }

    /**
     * Function that sends a web-service function call to the wsdl web-service based on function type and parameters
     *
     * @param $soap_client - variable containing the SOAP client handle
     * @param $webservice_function - variable containing the name of the function to call
     * @param $webservice_call_paramaters - variable containing the parameters for the function call
     * @return \Exception|\SoapFault|null - exception thrown when faulty parameters or functions are provided
     */
    public function performSoapCall($soap_client, $webservice_function, $webservice_call_paramaters) {
        $soap_call_result = null;

        switch ($webservice_function) {
            case 'peekMessages':
                if ($soap_client) {
                    try {
                        $webservice_call_result = $soap_client-> {$webservice_function}($webservice_call_paramaters['ee_username'], $webservice_call_paramaters['ee_password'], $webservice_call_paramaters['sms_dl_nr']);
                        $soap_call_result = $webservice_call_result;
                    }
                    catch (\SoapFault $exception) {
                        $soap_call_result = $exception;
                    }
                }
                break;
            case 'sendMessage':
                if ($soap_client) {
                    try {
                        $webservice_call_result = $soap_client->{$webservice_function}($webservice_call_paramaters['ee_username'], $webservice_call_paramaters['ee_password'], $webservice_call_paramaters['send_phone_nr'], $webservice_call_paramaters['msg_box'], false, "SMS");
                        $soap_call_result = $webservice_call_result;
                    }
                    catch (\SoapFault $exception) {
                        $soap_call_result = $exception;
                    }
                }
                break;
            default:
        }
        return $soap_call_result;
    }
}