<?php
namespace App\DB;

use \PDO;

class Database extends PDO
{
    // Class properties
    private $DBH;
    public $config;

    public function __construct()
    {
        // Connection information
        $this->config = parse_ini_file('config.ini', true);

        // Attempt DB connection
        try {
            $host = $this->config['host'];
            $dbname = $this->config['dbname'];
            $user = $this->config['user'];
            $pass = $this->config['pass'];

            $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRow($query, $params = array())
    {
        try {
            $stmt = $this->DBH->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
