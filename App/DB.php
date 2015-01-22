<?php

//Lookup msisdn
//preveri številko - get 
//E.164 protokol
namespace App\DB;

use \PDO;

class Database extends PDO
{
    # Class properties
    private $DBH; // Database Handle
    private $STH; // Statement Handle

    # Func: __construct()
    # Desc: Connects to DB
    public function __construct()
    {
        // Connection information
        $host   = 'localhost'; //change this
        $dbname = 'msisdn'; //change this if needed
        $user   = 'root'; //change this
        $pass   = ''; //change this

        // Attempt DB connection
        try {
            $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRows($query, $params = array())
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function getRow($query, $params = array())
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
