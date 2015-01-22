<?php
//Lookup msisdn
//preveri številko - get 
//E.164 protokol
namespace DB;

class FlatDB {

    static $arr = array(
    //Africa

    //Asia

    //Europe
        //Slovenia
        array('code' => '386', 'country' => 'Slovenia', 'isoCountry' => 'SI'),
        //France
        array('code' => '33', 'country' => 'France', 'isoCountry' => 'FR')

    //North America

    //South America

    //Antarctica

    //Australia
    );
    static $ndc = array(
        array('code' => '386', "NDC" => '40', "Network" => "SI Mobil D.D", "Operator" => "Si.mobil"),
        array('code' => '386', "NDC" => '30', "Network" => "SI Mobil D.D", "Operator" => "Si.mobil"),
        array('code' => '386', "NDC" => '41', "Network" => "Ipkonet", "Operator" => "Mobitel"),
        array('code' => '386', "NDC" => '64', "Network" => "T-2 d.o.o.", "Operator" => "T-2"),
        array('code' => '386', "NDC" => '70', "Network" => "Tusmobil d.o.o.", "Operator" => "Tušmobil"),
    );


    static function checkIfexist($find) {
        for($i = 1; $i <= 3; $i++) {
            $results = self::in_array_r(substr($find, 0,$i),self::$arr,true);
            if($results) {
                $results["intID"] = $i;
                break;
            }
        }
        if (empty($results))  $results["error"] = "Ni v bazi!";
        return $results;
    }

    static function checkIfexistNetwork($find, $ndc) {
        for($i = 1; $i <= 3; $i++) {
            $results = self::in_array_r_where(substr($ndc, 0,$i), self::$ndc, $find);
            if($results) {
                $results["intNDC"] = $i;
                break;
            }
        }
        return $results;
    }
    static function in_array_r_where($needle, $haystack, $where) {
        $whereColumn = array();
        foreach ($haystack as $item) {
            if ($item['code'] === $where) {
                 array_push($whereColumn,$item); //najde vse kjer je code = $where
            }
        }

        $results = self::in_array_r($needle, $whereColumn, true);
        print_r($results);

        //vedno prazno!?!

        return $results;
    }
    static function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return $item;
            }
        }
        return false;
    }
}

?>