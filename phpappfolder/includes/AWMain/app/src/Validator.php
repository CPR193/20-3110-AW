<?php
/**
 * Validator Class for validating received data before further processing
 *
 * @package AWMain
 * @author 20-3110-AW - Cosmin
 */

namespace AWMain;


class Validator
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Function that validates telemetry data, making it ready to be sent via the SOAP client
     *
     * @param $send_param - variable containing telemetry data parameters to be validated
     * @return array - array containing validated telemetry data
     */

    public function validateSendData($send_param){
        $processed_param = [];
        $nr_to_check = $send_param['send_phone_nr'];
        $group_id = '&lt;groupid&gt;20-3110-AW&lt;/groupid&gt;';
        $send_param['switch_1_param'] = '&lt;switch1&gt;'. $send_param['switch_1_param'] . '&lt;/switch1&gt;';
        $send_param['switch_2_param'] = '&lt;switch2&gt;'. $send_param['switch_2_param'] . '&lt;/switch2&gt;';
        $send_param['switch_3_param'] = '&lt;switch3&gt;'. $send_param['switch_3_param'] . '&lt;/switch3&gt;';
        $send_param['switch_4_param'] = '&lt;switch4&gt;'. $send_param['switch_4_param'] . '&lt;/switch4&gt;';
        $send_param['fan_param'] = '&lt;fan&gt;' . $send_param['fan_param'] . '&lt;/fan&gt;';
        $send_param['heater_param'] = '&lt;heater&gt;' . $send_param['heater_param'] . '&lt;/heater&gt;';
        $send_param['keypad_param'] = '&lt;keypad&gt;' . $send_param['keypad_param'] . '&lt;/keypad&gt;';
        $send_param['e_mail'] = '&lt ;email&gt;' . $send_param['e_mail'] . '&lt;/email&gt;';

        if (isset($nr_to_check)) {
            $nr_to_check = str_replace(' ', '', $nr_to_check);
            if(!empty($nr_to_check) && (strlen($nr_to_check)>8) && (strlen($nr_to_check)<16) && (is_numeric($nr_to_check))) {
                switch ($nr_to_check) {
                    case (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+1) == '0'):
                        $send_param['send_phone_nr'] = '+44' . substr($nr_to_check, - strlen($nr_to_check)+1);
                        break;
                    case ((substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '44')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '33')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '32')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '40')
                    ):
                        $send_param['send_phone_nr'] = '+' . $nr_to_check;
                        break;
                    case ((substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+44')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+33')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+32')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+40')
                    ):
                        $send_param['send_phone_nr'] = $nr_to_check;
                        break;
                    default:
                }
            }
        }
        $processed_param['ee_username'] = $send_param['ee_username'];
        $processed_param['ee_password'] = $send_param['ee_password'];
        $processed_param['send_phone_nr'] = $send_param['send_phone_nr'];
        $proc_msg_body = $group_id . $send_param['e_mail'] . $send_param['switch_1_param']
                        . $send_param['switch_2_param'] . $send_param['switch_3_param'] . $send_param['switch_4_param']
                        . $send_param['fan_param'] . $send_param ['heater_param'] . $send_param['keypad_param'];
        $processed_param['msg_box'] = $proc_msg_body;

        return $processed_param;
    }
}