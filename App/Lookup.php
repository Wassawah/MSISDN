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

    public $return;

    public function arrayFill($key,$value)
    {
        $this->return[$key] = $value;
    }
    public function msisdn($number)
    {
        //clean up the number
        $number = $this->cleanNumber($number);

        if ($number) {
            //connect to base via PDO
            

            //first need to check what country is it, so first 3 numbers
            //$whereId = "country_code";
            //$what = "country_code, country, ISO";
            //$result = $this->checkQuery($number, $whereId, $dataB, $what);
            $obj = new Tools;

            $obj->value = $number;
            $obj->valueId = "country_code";
            $obj->what = "country_code, country, ISO";
            $obj->checkQuery();

            $this->return = $obj->result;
            $obj->cleanUp();

            if (!empty($this->return)) {
                //check what network -> country code
                $obj->value = substr($number, $obj->modeID, 3);
                $obj->valueId = "ndc";
                $obj->what = "*";
                $obj->where = "AND country_code  = " . $this->return['country_code'];

                $obj->checkQuery();
                $returned= $obj->result;
                $obj->cleanUp();

                if (empty($returned)) {
                    $this->return['error'] = 'Unknown NDC';
                } else {
                    $this->return = $returned;
                    $this->return['numberDetail'] = $this->return['country_code'] ." ". $this->return['ndc'] ." ". substr($number, $obj->modeID);
                    $this->return['Subscribe'] = substr($number, $obj->modeID);
                }
            } else {
                $this->arrayFill('error', 'Unknown Country');
            }
        } else {   
            $this->arrayFill('error', 'This is not a MSISDN?');
        }
        $this->arrayFill('number', $number);
        return $this->return;
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
class Tools
{
    public $database = "";

    public $value = "";
    public $valueId = "";
    public $where = "";
    public $what = "";

    public $modeID;
    public $result;

    public function __construct()
    {
        $this->database = new \App\DB\Database();
    }

    public function checkQuery() {
        for ($i=1; $i <= 3; $i++) {
            $dynamicValue= substr($this->value, 0, $i);

            $query = "SELECT $this->what FROM info WHERE $this->valueId = $dynamicValue $this->where";
            $return = $this->database->getRow($query);
            if ($return) {
                $this->result = $return;
                $this->modeID += $i;
            }
        }
    }

    public function cleanUp()
    {
        $this->value = "";
        $this->valueId = "";
        $this->where = "";
        $this->what = "";
        $this->result ="";
    }

    public function getResult()
    {
      return $this->result;
    }
}