<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
        <input type="submit" name="submit" value="Ajouter"><br>
    </form>

    <?php
    $file = "tasks.txt";
    $fileOpen = fopen($file, "a");
    if (
        !empty($_GET["name"]) and
        !empty($_GET["description"]) and
        !empty($_GET["date"])
    ) {
        $nouvelleTache = $_GET['name'] . "+-+" . $_GET['description'] . "+-+" . $_GET['date'];
        fwrite($fileOpen, $nouvelleTache . "\n");
        // fwrite(
        //     $fileOpen,
        //     "<tr><th scope='row'>" .
        //         $_GET["name"] .
        //         "</th><td>" .
        //         $_GET["description"] .
        //         "</td><td>" .
        //         $_GET["date"] .
        //         '</td><td><form><input type="submit" name="submit" value="Ok"><form></td></tr>'
        // );
        header("Location: index.php");
    }

    fclose($fileOpen);

    ?>

    <table class="table m-auto">
        <thead class="table-dark">
            <tr>
                <th scope="col">Tâche</th>
                <th scope="col">Déscription</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php

            $contenu = file_get_contents($file);
            $taches = explode("\n", $contenu);

            for ($i = 0; $i < count($taches) - 1; $i++) {
                echo "<tr>";
                $tacheUnitaire = explode("+-+", $taches[$i]);
                for ($j = 0; $j < count($tacheUnitaire); $j++) {
                    echo "<td>" . $tacheUnitaire[$j] . "</td>";
                }
                echo "<td><form><input type='submit' name='submitOk" . $i . "' value='Ok'></td>";
                echo "</tr>";

                if (isset($_GET['submitOk' . $i . ''])) {
                    echo "hello";
                };
            };
            ?>

        </tbody>
    </table>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>