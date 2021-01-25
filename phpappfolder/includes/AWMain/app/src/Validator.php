<?php
/** Validator for received input text field data*/

namespace AWMain;


class Validator
{
    public function __construct(){}
    public function __destruct(){}

    public function validatePhoneNr($nr_to_check){
        $check = false;
        if (isset($nr_to_check)) {
            $nr_to_check = str_replace(' ', '', $nr_to_check);
            if(!empty($nr_to_check) && (strlen($nr_to_check)>8) && (strlen($nr_to_check)<16) && (is_numeric($nr_to_check))) {
                switch ($nr_to_check) {
                    case (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+1) == '0'):
                        $check = '+44' . substr($nr_to_check, - strlen($nr_to_check)+1);
                        break;
                    case ((substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '44')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '33')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '32')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+2) == '40')
                    ):
                        $check = '+' . $nr_to_check;
                        break;
                    case ((substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+44')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+33')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+32')
                        || (substr($nr_to_check, - strlen($nr_to_check), -strlen($nr_to_check)+3) == '+40')
                    ):
                        $check = $nr_to_check;
                        break;
                    default:
                }
            }
        }
        return $check;
    }

    public function validateUsername($str_to_check) {

    }
}