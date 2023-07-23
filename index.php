<?php

use App\Controllers\TasksController;
require 'vendor/autoload.php';

//1. instanciar (crear un objeto) la clase BooksController para acceder a sus métodos

$taskController = new TasksController;

// 2. Ejecutar el métdo store() del controlador

$taskController -> store([
    "task" => "Hacer maletas para vacaciones",
    "descripcion" => "meter bikinis",
    "creation_date" => "2023-07-23"
]);
