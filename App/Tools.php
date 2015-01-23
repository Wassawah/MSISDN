<?php
namespace App\Tools;

class Hammer
{
    public $database = "";

    public $value = "";
    public $valueNdc = "";

    public $modeID;
    public $result;

    public function __construct()
    {
        $this->database = new \App\DB\Database();
    }

    public function checkQuery()
    {
        for ($i=1; $i <= 3; $i++) {
            if (!empty($this->valueNdc)) {
                $valueNdc = substr($this->valueNdc, 0, $i);
                $value = $this->value;

                $query = "SELECT * FROM info WHERE country_code = :value AND ndc = :valueNdc";
                $params = array('value' => $value, 'valueNdc' => $valueNdc,);
            } else {
                $value = substr($this->value, 0, $i);

                $query = "SELECT country_code, country, ISO FROM info WHERE country_code = :value";
                $params = array('value' => $value);
            }

            $return = $this->database->getRow($query, $params);
            if ($return) {
                $this->result = $return;
                $this->modeID += $i;
            }
        }
    }
    public function cleanUp()
    {
        $this->value = "";
        $this->valueNdc = "";
        $this->result = "";
    }

    public function getResult()
    {
        return $this->result;
    }
}
