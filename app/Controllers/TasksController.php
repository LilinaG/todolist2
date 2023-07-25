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
            header("Location:/todolist2/public/tasks/");
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
     * CREATE: Capturar los datos del formulario para el store 
     */


     public function create(){
        require("../src/views/tasksView/create.php");

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

                require("../src/views/tasksView/index.php");           

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

     /**
     * DELETE: Elimina un registro seleccionado.
     */

     public function delete($id){
         //Definir la Query de INSERT
       
         $query = "DELETE FROM tasks WHERE id=:id";

         //Preparar la Query
         $result= $stm = $this->connection -> get_connection()->prepare($query);

         //Ejecutar la Query
         $stm -> execute([":id" => $id]);

         if(!empty($result)){
            header("Location:/todolist2/public/tasks/");
        } else{
         echo "Task not deleted";
        }
    }
    

            /**
     * EDIT: Mostrar el formulario de edición de una tarea específica.
     */
    public function edit($id) {
        // Definir la Query para obtener los datos de la tarea a editar
        $query = "SELECT * FROM tasks WHERE id=:id";

        // Preparar la Query
        $stm = $this->connection->get_connection()->prepare($query);

        // Ejecutar la Query
        $stm->execute([":id" => $id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        // Verificar si se encontró la tarea
        if (!empty($result)) {
            // Mostrar el formulario de edición con los datos de la tarea
            require("../src/views/tasksView/edit.php");
        } else {
            echo "Task not found";
        }
    }

    /**
     * UPDATE: Actualizar una tarea específica.
     */
    public function update($id, $data) {
        // Definir la Query para actualizar la tarea en la base de datos
        $query = "UPDATE tasks SET task = ?, descripcion = ?, creation_date = ? WHERE id = ?";

        // Preparar la Query
        $stm = $this->connection->get_connection()->prepare($query);

        // Ejecutar la Query
        $results = $stm->execute([
            $data['task'],
            $data['descripcion'],
            $data['creation_date'],
            $id
        ]);

        // Redirigir a la página de detalles de la tarea actualizada
        header("Location: /todolist2/public/tasks/$id");
    }
    
}