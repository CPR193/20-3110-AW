<?php
/** Wrapper clas for communicating to a web-service via a SOAP client
 *
 */

namespace AWMain;

class SoapWrapper
{
    public function __construct(){}
    public function __destruct(){}

    public function createSoapClient() {
        $soap_client_handle = false;
        $soap_client_parameters = array();
        $exception = '';
        $wsdl = WSDL;

        $soap_client_parameters = ['trace' => true, 'exceptions' => true];
        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
            //var_dump($soap_client_handle->__getFunctions());
            //var_dump($soap_client_handle->__getTypes());
        }
        catch (\SoapFault $exception) {
            $soap_client_handle = 'Something went wrong connecting to the data supplier!';
        }
        return $soap_client_handle;
    }

    public function performSoapCall($soap_client, $webservice_function, $webservice_call_paramaters, $webservice_value) {
        $soap_call_result = null;
        $raw_xml = '';

        if ($soap_client) {
            try {
                $webservice_call_result = $soap_client->{$webservice_function}($webservice_call_paramaters['ee_username'], $webservice_call_paramaters['ee_password'], $webservice_call_paramaters['sms_dl_nr']);
                $soap_call_result = $webservice_call_result;//->{$webservice_value};
            }
            catch (\SoapFault $exception) {
                $soap_call_result = $exception;
            }
        }
        return $soap_call_result;
    }

    public function performSoapSend($soap_client, $webservice_function, $webservice_call_paramaters, $webservice_value) {
        $soap_call_result = null;
        $raw_xml = '';

        if ($soap_client) {
            try {
                $webservice_call_result = $soap_client->{$webservice_function}($webservice_call_paramaters['ee_username'], $webservice_call_paramaters['ee_password'], $webservice_call_paramaters['send_phone_nr'], $webservice_call_paramaters['msg_box'], false, "SMS");
                $soap_call_result = $webservice_call_result; //->{$webservice_value};
            }
            catch (\SoapFault $exception) {
                $soap_call_result = $exception;
            }
        }
        return $soap_call_result;
    }
}