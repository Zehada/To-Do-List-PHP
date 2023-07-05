<?php
session_start();

if (!isset($_SESSION["newSession"])) {
    $fileOpenStart = fopen("tasks.txt", "w+");
    fwrite($fileOpenStart, "");
    fclose($fileOpenStart);
    $_SESSION["newSession"] = true;
}
?>




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
    <form id="taskForm" class="m-4" action="">
        <label class="form-label" for="taskName">Tâche</label><br>
        <input class="form-control" type="text" name="name" id="taskName" autocomplete="off" value="<?php echo $_GET['name'] ?? ''; ?>"><br>
        <label class="form-label" for="taskDescription">Description</label><br>
        <input class="form-control" type="text" name="description" id="taskDescription" autocomplete="off" value="<?php echo $_GET['description'] ?? ''; ?>"><br>
        <label class="form-label" for="taskDateLimit">Date limite</label><br>
        <input class="form-control" type="date" name="date" id="taskDateLimit" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $_GET['date'] ?? ''; ?>"><br>
        <input class="btn btn-dark" type="submit" name="submit" value="Ajouter"><br>
    </form>

    <?php
    $file = "tasks.txt";
    $fileOpen = fopen($file, "a");

    if (isset($_GET['submit'])) {
        if (!empty($_GET["name"]) and !empty($_GET["description"]) and !empty($_GET["date"])) {
            $nouvelleTache = $_GET['name'] . "+-+" . $_GET['description'] . "+-+" . $_GET['date'] . "+-+" . uniqid();
            fwrite($fileOpen, $nouvelleTache . "\n");
            header("Location: index.php");
        } else {
            echo "<p class='message-erreur'>Veuillez remplir tous les champs</p>";
        }
    }
    fclose($fileOpen);


    ?>


    <table class="table m-auto">
        <thead class="table-dark">
            <tr>
                <th scope="col">Tâche/Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php

            $contenu = file_get_contents($file);
            $taches = explode("\n", $contenu);
            $result = '';
            $tachesOk = array();



            for ($i = 0; $i < count($taches) - 1; $i++) {


                $tacheUnitaire = explode("+-+", $taches[$i]);
                $id = end($tacheUnitaire);

                if (strpos($taches[$i], 'modifié123') === false) {

                    echo "<tr>";

                    for ($j = 0; $j < count($tacheUnitaire) - 1; $j++) {
                        echo "<td>" . $tacheUnitaire[$j] . "</td>";
                    }
                    echo "<td><form><button class='modifier btn bg-transparent p-0' type='submit' name='submitModify" . $i . "'><img src='images/modifier.png' alt=''></button></form><form><button class='supprimer btn bg-transparent p-0 mt-2' type='submit' name='submitOk" . $i . "'><img src='images/supprimer.png' alt=''></button></form></td>";
                    echo "</tr>";
                } else {
                    echo "<tr><form id='modify" . $id . "'></form><td><input class='form-control nameModify' type='text' name='nameModify" . $id . "' form='modify" . $id . "' value='" . str_replace(array("'", '"'), array("&apos;", '&quot;'), $tacheUnitaire[0]) . "'></td><td><input class='form-control descriptionModify' type='text' name='descriptionModify" . $id . "' form='modify" . $id . "' value='" . str_replace(array("'", '"'), array("&apos;", '&quot;'), $tacheUnitaire[1]) . "'></td><td><input class='form-control dateModify' type='date' min='" . date('Y-m-d') . "' name='dateModify" . $id . "' form='modify" . $id . "' value='" . $tacheUnitaire[2] . "'></td><td><button class='modify btn bg-transparent p-0' type='submit' name='submitModifie" . $id . "' form='modify" . $id . "'><img src='images/modifier.png' alt=''></button></td></tr>";
                }


                if (isset($_GET['submitOk' . $i . ''])) {
                    foreach ($taches as $tache) {
                        if ($tache != $taches[$i]) {
                            array_push($tachesOk, $tache);
                        }
                    }
                    $result = implode("\n", $tachesOk);
                    echo $result;
                    $fileOpenOk = fopen($file, "w+");
                    fwrite($fileOpenOk, $result);
                    fclose($fileOpenOk);

                    header("Location: index.php");
                }



                if (isset($_GET['submitModify' . $i . ''])) {
                    $taskModify = $tacheUnitaire[0] . "+-+" . $tacheUnitaire[1] . "+-+" . $tacheUnitaire[2] . "+-+" . "modifié123" . "+-+" . uniqid();

                    array_push($tachesOk, $taskModify);

                    foreach ($taches as $tache) {
                        if ($tache != $taches[$i]) {
                            array_push($tachesOk, $tache);
                        }
                    }

                    $result = implode("\n", $tachesOk);
                    $fileOpenOk = fopen($file, "w+");
                    fwrite($fileOpenOk, $result);
                    fclose($fileOpenOk);

                    header("Location: index.php");
                }


                if (isset($_GET['submitModifie' . $id . ''])) {
                    if (!empty($_GET['nameModify' . $id . '']) and !empty($_GET['descriptionModify' . $id . '']) and !empty($_GET['dateModify' . $id . ''])) {
                        $taskModifie = $_GET['nameModify' . $id . ''] . "+-+" . $_GET['descriptionModify' . $id . ''] . "+-+" . $_GET['dateModify' . $id . ''] . "+-+" . uniqid();
                        array_push($tachesOk, $taskModifie);
                        foreach ($taches as $tache) {
                            if ($tache != $taches[$i]) {
                                array_push($tachesOk, $tache);
                            }
                        }
                        $result = implode("\n", $tachesOk);
                        $fileOpenOk = fopen($file, "w+");
                        fwrite($fileOpenOk, $result);
                        fclose($fileOpenOk);

                        header("Location: index.php");
                    } else {
                        echo "<p class='message-erreur'>Veuillez remplir tous les champs</p>";
                    }
                }
            };


            ?>

        </tbody>
    </table>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>