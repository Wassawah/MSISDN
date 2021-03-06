<?php
namespace App;

class Lookup
{

    public function __construct()
    {
        require_once("App/DB.php");
        require_once("App/Tools.php");
    }

    public $return;

    public function arrayFill($key, $value)
    {
        $this->return[$key] = $value;
    }

    public function msisdn($number)
    {
        //clean up the number
        $number = $this->cleanNumber($number);

        if ($number) {
            //connect to base via PDO
            $obj = new \App\Tools\Hammer();

            //first need to check what country is it, so first 3 numbers
            $obj->value = $number;
            $obj->checkQuery();

            $this->return = $obj->result;
            $obj->cleanUp();

            if (!empty($this->return)) {
                //check what network -> country code
                $contryCode = $this->return['country_code'];
                $obj->valueNdc = substr($number, $obj->modeID, 3);
                $obj->value = $contryCode;
                $obj->checkQuery();

                $returned = $obj->result;
                $obj->cleanUp();

                if (empty($returned)) {
                    $this->return['error'] = 'Unknown NDC';
                } else {
                    $this->return = $returned;
                    $subscribe = substr($number, $obj->modeID);
                    $this->return['numberDetail'] = $contryCode ." ". $this->return['ndc'] ." ". $subscribe;
                    $this->return['Subscribe'] = $subscribe;
                    $this->return['numberDetail'] = $contryCode ." ". $subscribe;
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

    public function cleanNumber($number)
    {
        //add sql inject perventor
        
        $number = $this->pregReplace('/\D/', '', $number); //allow only numbers
        $number = $this->pregReplace('/(^00)/', '', $number); //remove double zero
        
        //11 or 15 character is MSISDN!? So i could put that higher :D
        if (strlen($number) < 6) {
            return false;
        }
        return $number;
    }
    public function pregReplace($what, $with, $string)
    {
        return preg_replace($what, $with, $string);
    }
}
