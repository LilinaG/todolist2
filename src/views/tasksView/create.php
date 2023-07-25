<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
    <h1>Add Task</h1>
    <form action="/todolist2/public/tasks" method="post">
        <label for="">Task</label>
        <input type="text" name="task" id="task" required>

        <label for="">Descripcion</label>
        <input type="text" name="descripcion" id="descripcion">

        <label for="">Creation Date</label>
        <input type="date" name="creation_date" id="creation_date">

        <input type="hidden" name="method" value="post">

        <button type="submit">Save</button>

     

    
</body>
</html>