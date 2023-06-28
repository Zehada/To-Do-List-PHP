<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<body>
    <form action="">
        <label for="fname">Tâche :</label><br>
        <input type="text" name="name" id="taskName"><br>
        <label for="fname">Déscription :</label><br>
        <input type="text" name="description" id="taskDescription"><br>
        <label for="fname">Date limite :</label><br>
        <input type="date" name="date" id="taskDateLimit"><br>
        <input type="submit" value="Ajouter"><br>
        
       <?php
    $taskName = $_GET['name'];
    $taskDescription = $_GET['description'];
    $taskDateLimit = $_GET['date'];
    $file = "tasks.txt";
    $fileOpen = fopen($file, "a");
    fwrite($fileOpen, "Tâche : " . $taskName . "<br>" . "Déscription : " . $taskDescription . "<br>" . "Date limite : " . $taskDateLimit . '<br> <input type="checkbox" name="checkbox" id="taskCheckbox">');
    echo file_get_contents($file);
    fclose($fileOpen);
   

    
    ?>
    
    
    </form>
 
</body>
</html>