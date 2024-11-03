<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php
include "prostredi.php";
require_once('dbconnect.php');
require_once('bezpecnost2.php');

// Získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

// Pokud není uživatel přihlášen, přesměruj na přihlašovací stránku
if (!$userId) {
    header("Location: prihlaseni.php");
    exit();
}

// Získání seznamu projektů
$projects = getProjects($conn);

// Inicializace proměnné pro název vybraného projektu
$selectedProjectName = '';

// Zpracování formuláře
if (isset($_POST['showTasks'])) {
    // Získání vybraného ID projektu z formuláře
    $selectedProjectID = isset($_POST['projectSelect']) ? $_POST['projectSelect'] : null;

    // Získání názvu vybraného projektu
    if ($selectedProjectID) {
        foreach ($projects as $project) {
            if ($project['ID_projektu'] == $selectedProjectID) {
                $selectedProjectName = $project['Nazev_projektu'];
                break;
            }
        }

        // Načtení úkolů pod vybraným projektem
        $tasks = getTasksByProject($conn, $selectedProjectID);
    } else {
        // Zpracování chyby nevybrání projektu
        echo "Prosím, vyberte projekt.";
    }
} else {
    $tasks = array(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>
<div class="homepage-container">
    <div class="homepage-column">
        <h2>Můj To-Do List</h2>

        <!-- Formulář pro výběr projektu -->
        <form method="post" action="">
            <select id="projectSelect" name="projectSelect">
                <?php
                foreach ($projects as $project) {
                    echo '<option value="' . $project['ID_projektu'] . '">' . $project['Nazev_projektu'] . '</option>';
                }
                ?>
            </select>
            <button type="submit" name="showTasks">Načíst úkoly</button>
        </form>

        <!-- Tabulka pro zobrazení úkolů -->
        <table class="task-table">
            <thead>
                <tr>
                    <th>Název úkolu</th>
                    <th>Datum vypršení</th>
                    <th>Čas vypršení</th>
                    <th>Priorita</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($tasks as $task) {
                    echo '<tr>';
                    echo '<td>' . $task['Nazev_ukolu'] . '</td>';
                    echo '<td>' . $task['datum_vyprseni'] . '</td>';
                    echo '<td>' . $task['cas_vyprseni'] . '</td>';
                    echo '<td>' . $task['priorita'] . '</td>';
                    echo '<td>';
                    echo '<i class="fas fa-check" onclick="completeTask5(' . $task['ID_Ukolu'] . ')"></i>&nbsp';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <h2>Váš motivační text pro lepší den</h2>
<p id="motivationText">Klikněte pro načtení motivace.</p>
<button type="button" onclick="loadMotivation()">Načíst nový motivující text</button>
    </div>
</div>

<div class="custom-dialog" id="completeTaskDialog">
    <p>Chcete označit úkol jako splněný?</p>
    <button onclick="confirmCompleteTask5()">Ano</button>
    <button onclick="closeCompleteTaskDialog5()">Zrušit</button>
    <!-- Skryté pole pro uchování ID úkolu -->
    <input type="hidden" id="completedTaskId">
</div>

<div class="image-container">
    <img src="images/todolistobrazek.png" alt="Image 1" class="left-image">
    <img src="images/todolistobrazek.png" alt="Image 2" class="right-image">
</div>


<script src="skripty77.js"></script> 

</body>
</html>
