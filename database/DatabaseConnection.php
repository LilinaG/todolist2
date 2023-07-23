<?php

namespace Database;

class DatabaseConnection{
 private $server;
 private $username;
 private $password;
 private $database;
 private $connection;

 public function __construct($server, $username, $password, $database){
    $this-> server =$server;
    $this-> username =$username;
    $this-> password =$password;
    $this-> database =$database;
 }

 public function connect(){
    try {
        $this->connection = new \PDO("mysql:host=$this->server;dbname=$this->database", $this->username, $this->password);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->connection->exec("SET NAMES 'utf8'");
    } catch(\PDOException $e) { 
        echo "Problemas con la conexión: " . $e->getMessage();
    }
}
 public function get_connection(){
    return $this->connection;
 }
}


/*$server = "localhost";
$username = "root";
$password ="";
$database = "todolist2";

$connection = new DatabaseConnection($server, $username, $password, $database);
$connection -> connect();

$query = "SELECT * FROM tasks";
$stm = $connection -> get_connection()->prepare($query);
$stm->execute();
$results = $stm -> fetchAll(PDO::FETCH_ASSOC);

print_r($results);

foreach($results as $result){
    echo $result['task'] . "\n";
}*/