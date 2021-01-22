<?php


namespace AWMain;


class M2MSoapModel
{
    private $result;
    private $soap_wrapper;
    private $xml_parser;

    public function __construct(){
        $this->soap_wrapper = null;
        $this->xml_parser = null;
        $this->result = [];
    }
    public function __destruct(){}

    public function setSoapWrapper($soap_wrapper) {
        $this->soap_wrapper = $soap_wrapper;
    }

    public function retrieveSMS($webservice_call_paramaters) {

        $soapresult = [];
        $arr_sms = [];

        $soap_client_handle = $this->soap_wrapper->createSoapClient();
        if ($soap_client_handle !== false) {
            $webservice_function = "peekMessages";
            $this->webservice_call_paramaters = $webservice_call_paramaters;
            $webservice_value = '<message_content>';
            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_paramaters, $webservice_value);

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

    public function getResult() {
        return $this->result;
    }
}
