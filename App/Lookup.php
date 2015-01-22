<?php
//Lookup msisdn
//preveri številko - get
//E.164 protokol
namespace App;

class Lookup
{

    public function __construct()
    {
        include "App/DB.php";
    }
    
    private $modeID = 0;

    public static function msisdn($number)
    {
        $self = new Lookup;
        //clean up the number
        $number = $self->cleanNumber($number);
        if ($number != "") {
            //connect to base via PDO
            $dataB = new \App\DB\Database();

            //first need to check what country is it, so first 3 numbers
            
            $countyCode = $self->checkCountry($number, $dataB);
            $result = $countyCode;
            if (!empty($countyCode)) {
                //check what network -> country code
                $returned = $self->checkNetwork($countyCode['country_code'], substr($number, $self->modeID, 3), $dataB);
                if (empty($returned)) {
                    $result['error'] = "Unknown NDC";
                } else {
                    $result = $returned;
                    $result['numberDetail'] = $result['country_code'] ." ". $result['ndc'] ." ". substr($number, $self->modeID);
                }
            } else {
                $result['error'] = "Unknown Country";
            }
            $result['Subscribe'] = substr($number, $self->modeID);
        } else {           
            $result['error'] = "Cant be null";
        }
        $result['number'] = $number;
        //print_r($result);
        return $result;
    }
    public function cleanNumber($number)
    {
        $number = preg_replace('/\D/', '', $number); //allow only numbers
        $number = preg_replace('/(^00)/', '', $number); //remove double zero

        return $number;
    }

    public function checkCountry($number, $dataB)
    {
        for ($i=1; $i <= 3; $i++) {
            //get first three characters
            $countyCode = substr($number, 0, $i);
            //chech if in base
            $return = $dataB->getRow("SELECT country, country_code, ISO FROM info WHERE country_code = $countyCode");
            if ($return) {
                $this->modeID = $i;
                break;
            }
        }
        return $return;
    }

    public function checkNetwork($countyCode, $ndc, $dataB)
    {
        $result = array();
        //chech if in base
        for ($i=1; $i <= 3; $i++) {
            //get first three characters
            $ndcsub = substr($ndc, 0, $i);
            //chech if in base
            $return = $dataB->getRow("SELECT * FROM info WHERE country_code = $countyCode AND ndc = $ndcsub");
            if ($return) {
                $result = $return;
                $this->modeID += $i;
            }
            //we need only the last one (max 3, min 1)
            //if found at 1 still can overwrite after 3
            //example: 1-800-999-9999 US will found at 80 but its unknown so go to 800 T-Mobile
        }
        return $result;
    }
}
