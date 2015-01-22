<?php

//Lookup msisdn
//preveri številko - get 
//E.164 protokol
namespace MSISDN;

include "App/FlatDB.php";

class Lookup {
    static public function msisdn($number)
    {
    	$number = str_replace("+","",$number);
        $number = str_replace(" ","",$number);
        $numberSub = 0;

    	//first need to check what country is it, so first 3 numbers
		$county_code = self::checkCountry($number);

        if (!empty($county_code['code'])) {
        //check what network -> country code
            $ndcInfo = self::checkNetwork($county_code['code'],substr($number,$county_code['intID'],3));
        
            $result = array_merge($county_code, $ndcInfo);
            $numberSub = $result['intID'] + $result['intNDC'];
        }else {
            $result = $county_code;
        }
        $result['Subscribe'] = substr($number, $numberSub);
		return $result;
    }


    static private function checkCountry($number) {
    	//get first three characters
    	$county_code = substr($number, 0, 3);

    	//chech if in base
    	$check = \DB\FlatDB::checkIfexist($county_code);

    	return $check;
    }

    static private function checkNetwork($code,$NDC) {
        //chech if in base
        $check = \DB\FlatDB::checkIfexistNetwork($code,$NDC);

        return $check;
    }
}

?>