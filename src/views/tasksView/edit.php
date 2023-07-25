
Para añadir los métodos edit y update al CRUD y tener la opción de editar tareas, sigue los siguientes pasos:

Agregar el botón de "Edit" en la lista de tareas en index.php:
php
Copy code
<!-- index.php -->
<ul>
    <?php foreach($results as $result): ?>
        <li>
            <?= $result["task"] ?>.<br>
            <b>Descripcion:</b> <?= $result["descripcion"] ?>.<br>
            <b>Creation Date:</b> <?= $result["creation_date"] ?>
            <form action="/todolist2/public/tasks/<?= $result["id"] ?>" method="post">
                <input type="hidden" name="method" value="delete">
                <button type="submit">Delete</button>
            </form>
            <a href="/todolist2/public/tasks/edit/<?= $result["id"] ?>">
                <button>Edit</button>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
Agregar los métodos edit y update en TasksController.php:
php
Copy code
// TasksController.php
class TasksController {
    // ...

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

    // ...
}
Crear el archivo edit.php en el directorio src/views/tasksView/ para mostrar el formulario de edición:
php
Copy code
<!-- edit.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task</h1>
    <form action="/todolist2/public/tasks/update/<?= $result["id"] ?>" method="post">
        <label for="task">Task</label>
        <input type="text" name="task" id="task" value="<?= $result["task"] ?>" required>

        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion" value="<?= $result["descripcion"] ?>">

        <label for="creation_date">Creation Date</label>
        <input type="date" name="creation_date" id="creation_date" value="<?= $result["creation_date"] ?>">

        <input type="hidden" name="method" value="put">

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
