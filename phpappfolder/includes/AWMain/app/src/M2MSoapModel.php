<?php
/**
 * Collection class for storing parameter data for the SOAP Wrapper Class
 *
 * @package AWMain
 * @Author 20-3110-AW - Cosmin
 */

namespace AWMain;


class M2MSoapModel
{
    private $result;
    private $soap_wrapper;
    private $xml_parser;

    /**
     * Constructor function for the Class
     */
    public function __construct(){
        $this->soap_wrapper = null;
        $this->xml_parser = null;
        $this->result = [];
    }
    public function __destruct(){}

    /**
     * Function that sets the SOAP wrapper handle
     *
     * @param $soap_wrapper - variable containing the SOAP wrapper handle
     */
    public function setSoapWrapper($soap_wrapper) {
        $this->soap_wrapper = $soap_wrapper;
    }

    /**
     * Function that retrieves messages through the SOAP wrapper via the "peekMessages" web-service function
     * and returns the content between the <message></message> and <message_content></message_content> tags
     *
     * @param $webservice_call_paramaters - variable containing the SOAP call parameters
     */
    public function retrieveSMS($webservice_call_paramaters) {

        $soapresult = [];
        $arr_sms = [];

        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false) {
            $webservice_function = "peekMessages";
            $this->webservice_call_paramaters = $webservice_call_paramaters;
            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_paramaters);

            $arr_sms = $soapcall_result;
            $n = 1;
            foreach ($arr_sms as $sms) {

                if (strpos($sms, '<message_content>')>0) {
                $n_sms = substr($sms, strpos($sms, '<message_content>')+17);
                $n_sms = substr($n_sms, 0, strpos($n_sms, '</message_content>'));
                $soapresult[$sms] = $n . '. '. $n_sms;
                $n = $n+1;
                }
                elseif (strpos($sms, '<message>')>0) {
                    $n_sms = substr($sms, strpos($sms, '<message>')+9);
                    $n_sms = substr($n_sms, 0, strpos($n_sms, '</message>'));
                    $soapresult[$sms] = $n . '. '. $n_sms;
                    $n = $n+1;
                }
            }
        }
        $this->result = $soapresult;
    }

    /**
     * Function that returns the SOAP call results array
     *
     * @return array - array containing the results of the SOAP call
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * Function that delivers messages through the SOAP wrapper via the "sendMessage" web-service function
      *
     * @param $webservice_call_paramaters - variable containing the SOAP call parameters
     */
    public function deliverSMS($webservice_call_paramaters){
        $soapresult = [];

        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false) {
            $webservice_function = "sendMessage";
            $this->webservice_call_paramaters = $webservice_call_paramaters;
            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_paramaters);

            $soapresult = $soapcall_result;
        }
        $this->result = $soapresult;
    }
}
