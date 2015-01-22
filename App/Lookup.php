<?php
//Lookup msisdn
//preveri številko - get
//E.164 protokol
namespace App;

use Exception;

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
            $whereId = "country_code";
            $what = "country_code, country, ISO";
            $result = $self->checkQuery($number, $whereId, $dataB, $what);

            if (!empty($result)) {
                //check what network -> country code
                $where = "AND country_code  = " . $result['country_code'];
                $ndc = substr($number, $self->modeID, 3);
                $whereId = "ndc";
                $returned = $self->checkQuery($ndc, "ndc", $dataB, "*", $where);

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
            $result['error'] = "This is not a MSISDN?";
        }
        $result['number'] = $number;
        return $result;
    }

    public function checkQuery($ndc, $valueWhere, $dataB, $what = "*", $where = "") {
        $result = array();
        //chech if in base
        for ($i=1; $i <= 3; $i++) {
            //get first three characters
            $ndcsub = substr($ndc, 0, $i);
            //chech if in base
            $query = "SELECT $what FROM info WHERE $valueWhere = $ndcsub $where";
            $return = $dataB->getRow($query);
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

    public function cleanNumber($number) {
        $number = preg_replace('/\D/', '', $number); //allow only numbers
        $number = preg_replace('/(^00)/', '', $number); //remove double zero
        if (strlen($number) < 6) { //11 or 15 character is MSISDN!? So i could put that higher :D
            return false;
        }
        return $number;
    }
}
