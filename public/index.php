<?php





use App\Controllers\TasksController;
use Router\RouterHandler;
require __DIR__ . '/../vendor/autoload.php';


// obtener la URL de la vista en la que estamos
$slug = $_GET["slug"] ?? "";
$slug = explode("/", $slug);
$resource = $slug[0] == "" ? "/": $slug[0];
$id = $slug[1] ?? null;

// instancia del Router
$router = new RouterHandler;

switch($resource){
    case '/':
        echo "Home";
        break;
    case "tasks":
        $method = $_POST["method"] ?? "get";
        $router -> set_method($method);
        $router -> set_data($_POST);
        $router -> route(TasksController::class, $id);
        break;
        
    default:
        echo "404 Not Found";
        break;
}



//1. instanciar (crear un objeto) la clase BooksController para acceder a sus métodos

//$taskController = new TasksController;

// 2. Ejecutar el métdo store() del controlador

/*$taskController -> store([
    "task" => "Hacer comida para la semana",
    "descripcion" => "hacer lista de la compra",
    "creation_date" => "2023-07-23"
]);*/

//3. Ejecutar el método INDEX
//$taskController -> index();


//4. Ejectuar el método SHOW del controlador
//$taskController -> show(3);
