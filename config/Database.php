<?php

class Database {

    private $host='localhost';
    private $user='root';
    private $password='Nwanozie!97';
    private $dbname='location';
    private $conn;

    //DB Connect
    public function connect(){
        $this->conn=null;
        try{
            $this->conn = new PDO('mysql:host='. $this->host . ';dbname='.$this->dbname,$this->user,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo 'Connection Error:'. $e->getMessage();
        }
        
        return $this->conn;
    }
}

