<?php

namespace App\Controllers;
use Database\DatabaseConnection;
use Exception;

class TasksController{

    private $server;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct(){
         // Definir datos de conexión
        $this-> server = "localhost";
        $this-> username = "root";
        $this-> password = "";
        $this-> database = "todolist2";

         // Conectar a DB
         $this -> connection = new DatabaseConnection($this->server, $this->username, $this->password,$this->database); 
         $this-> connection -> connect();
     }

    /**
     * STORE: guardar registros en la base de datos
     */
    function store($data){
       
     //Definir la Query de INSERT

        $query = "INSERT 
                  INTO tasks (task, descripcion, creation_date)
                  VALUES (?, ?, ?)";

        //Preparar la Query
        $stm = $this->connection -> get_connection()->prepare($query);

        //Ejecutar la Query
        $results = $stm->execute([$data['task'],
                                  $data['descripcion'],
                                  $data['creation_date']
                                 ]);
        try {
            if (!empty($results)) {
                $statusCode = 200;
                $response = "Task '{$data['task']}' registered in your TODO list";
                echo $response;
                return [$statusCode, $response, $results];
                }
            } catch (Exception $e) {
                echo("An error occurred during database registration");
            } 
    }

     /**
     * INDEX: Listar registros de la BBDD
     */

    function index(){
               //Definir la Query de INSERT
       
                $query = "SELECT * FROM tasks";

                //Preparar la Query
                $stm = $this->connection -> get_connection()->prepare($query);

                //Ejecutar la Query
                $stm -> execute();
                $results = $stm-> fetchAll(\PDO::FETCH_ASSOC);

                if(!empty($results)){
                    foreach($results as $result){
                        echo $result['task']."<br>";
                    }
                 }
                 echo "No tasks registered";
    }


     /**
     * SHOW: mostrar un registro específico.
     */

     function show($id){
         //Definir la Query de INSERT
       
         $query = "SELECT * FROM tasks WHERE id=:id";

         //Preparar la Query
         $stm = $this->connection -> get_connection()->prepare($query);

         //Ejecutar la Query
         $stm -> execute([":id" => $id]);
         $result = $stm-> fetch(\PDO::FETCH_ASSOC);

         if(!empty($result)){
            echo $result['task'];  
        } else{
         echo "Task not found";
        }
     }



}