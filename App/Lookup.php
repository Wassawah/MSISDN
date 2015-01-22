<?php
//Lookup msisdn
//preveri številko - get
//E.164 protokol
namespace App;

require("App/DB.php");

class Lookup
{
    
    private $numberIDmove = 0;

    public static function msisdn($number)
    {
        $self = new Lookup;
        //clean up the number
        $number = $self->cleanNumber($number);
        if ($number != "") {
            //connect to base via PDO
            $db = new \App\DB\Database();

            //first need to check what country is it, so first 3 numbers

            $county_code = $self->checkCountry($number, $db);
            $result = $county_code;
            if (!empty($county_code)) {
                //check what network -> country code
                $returned = $self->checkNetwork($county_code['country_code'], substr($number, $self->numberIDmove, 3), $db);
                if (empty($returned)) {
                    $result['error'] = "Unknown NDC";
                } else {
                    $result = $returned;
                }
            }
            $result['Subscribe'] = substr($number, $self->numberIDmove);
        } else {
            $result['number'] = $number;
            $result['error'] = "Cant be null";
        }
        //print_r($result);
        return $result;
    }
    private function cleanNumber($number)
    {
        $number = preg_replace('/\D/', '', $number); //allow only numbers
        $number = preg_replace('/(^00)/', '', $number); //remove double zero

        return $number;
    }

    private function checkCountry($number, $db)
    {
        for ($i=1; $i <= 3; $i++) {
            //get first three characters
            $county_code = substr($number, 0, $i);
            //chech if in base
            $return = $db->getRow("SELECT * FROM info WHERE country_code = $county_code");
            if ($return) {
                $this->numberIDmove = $i;
                break;
            }
        }
        if (empty($return)) {
            $result['error'] = "Unknown";
        }
        return $return;
    }

    private function checkNetwork($county_code, $NDC, $db)
    {
        $result = array();
        //chech if in base
        for ($i=1; $i <= 3; $i++) {
            //get first three characters
            $NDCsub = substr($NDC, 0, $i);
            //chech if in base
            $return = $db->getRow("SELECT * FROM info WHERE country_code = $county_code AND ndc = $NDCsub");
            if ($return) {
                $result = $return;
                $this->numberIDmove += $i;
            }
            //we need only the last one (max 3, min 1)
            //if found at 1 still can overwrite after 3
            //example: 1-800-999-9999 US will found at 80 but its unknown so go to 800 T-Mobile
        }
        return $result;
    }
}
