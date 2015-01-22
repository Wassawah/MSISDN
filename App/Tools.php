<?php
//Lookup msisdn
//preveri številko - get
//E.164 protokol
namespace App\Tools;

class Hammer
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

    public function checkQuery()
    {
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
