<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO LIST</title>
</head>
<body>
    <h1>TODO LIST</h1>
    <a href="/todolist2/public/tasks/create">
        <button>Add tasks</button>
    </a>
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
            <a href="/todolist2/public/tasks/edit/{ID_DE_LA_TAREA}<?= $result["id"] ?>">
                <button>Edit</button>
            </a>
        
        </li>
        
        <?php endforeach; ?>
    </ul>
</body>
</html>