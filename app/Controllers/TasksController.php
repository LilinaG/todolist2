<?php

namespace App\Controllers;
use Database\DatabaseConnection;
use Exception;

class TasksController{
    /**
     * STORE: guardar registros en la base de datos
     */
    function store($data){
        // Definir datos de conexión
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "todolist2";

        //Connect to DB
        $connection = new DatabaseConnection($server, $username, $password, $database);
        $connection -> connect();

        //Definir la Query de INSERT

        $query = "INSERT 
                  INTO tasks (task, descripcion, creation_date)
                  VALUES (?, ?, ?)";

        //Preparar la Query
        $stm = $connection -> get_connection()->prepare($query);

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
}