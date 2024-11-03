<?php
include "prostredi.php";
require_once('dbconnect.php');
require_once('bezpecnost2.php');

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

$projects = getProjects($conn);

$selectedProjectName = '';  // Inicializujte proměnnou pro název vybraného projektu

if (isset($_POST['showTasks'])) {
    // Získání vybraného ID projektu z formuláře
    $selectedProjectID = $_POST['projectSelect'];

    // Získání názvu vybraného projektu
    foreach ($projects as $project) {
        if ($project['ID_projektu'] == $selectedProjectID) {
            $selectedProjectName = $project['Nazev_projektu'];
            break;
        }
    }

    // Načtení úkolů pod vybraným projektem
    $tasks = getTasksByProject100($conn, $selectedProjectID);
} else {
    // Pokud není vybrán projekt, můžete načíst výchozí nebo zobrazit žádné úkoly
    $tasks = array(); // nebo jiná výchozí hodnota
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa Úkolů - To-Do List Aplikace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div class="form3-container3">
    <div class="form3-column3">
        <h2>Správa úkolů</h2>

        <form action="spravaukolu.php" method="post">
            <label for="projectSelect"><h4>Vyberte projekt:<h4></label>
            <select id="projectSelect" name="projectSelect">
                <?php
                foreach ($projects as $project) {
                    echo '<option value="' . $project['ID_projektu'] . '">' . $project['Nazev_projektu'] . '</option>';
                }
                ?>
            </select>

            <button type="submit" name="showTasks">Zobrazit úkoly</button>
        </form>

        <?php
        // Zobrazení názvu vybraného projektu
        if (!empty($selectedProjectName)) {
            echo '<p>Aktuálně vybraný projekt: ' . $selectedProjectName . '</p>';
        }
        ?>

        <table class="task-table">
            <thead>
            <tr>
                <th>Název úkolu</th>
                <th>Datum vypršení</th>
                <th>Čas vypršení</th>
                <th>Priorita</th>
                <th>Bodové hodnocení</th>
                <th>Popis</th>
                <th>Stav úkolu</th>
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
    echo '<td>' . $task['bodove_hodnoceni'] . '</td>';
    echo '<td>' . $task['popis'] . '</td>';
    echo '<td>';
    if ($task['stav_ukolu'] == 0) {
        echo 'Aktivní';
    } elseif ($task['stav_ukolu'] == 1) {
        echo 'Splněno';
    }
    echo '<td>';

    echo '<i class="fas fa-check" onclick="completeTask5(' . $task['ID_Ukolu'] . ')"></i>&nbsp';
    echo '<i class="fas fa-edit" onclick="editTask5(' . $task['ID_Ukolu'] . ', \'' . $task['Nazev_ukolu'] . '\', \'' . $task['datum_vyprseni'] . '\', \'' . $task['cas_vyprseni'] . '\', \'' . $task['priorita'] . '\', \'' . $task['bodove_hodnoceni'] . '\', \'' . $task['popis'] . '\')"></i>&nbsp';
    echo '<i class="fas fa-trash" onclick="deleteTask5(' . $task['ID_Ukolu'] . ')"></i>';
    
    echo '</td>';
    echo '</tr>';
}
?>

            </tbody>
        </table>
    </div>
</div>

<div class="custom-dialog" id="editDialog">
    <h3>Upravit úkol</h3>
    <form id="editForm" onsubmit="saveEditedTask5(); return false;">
        <label for="editedNazev">Název úkolu:</label>
        <input type="text" id="editedNazev" required>
        <label for="editedDatum">Datum vypršení:</label>
        <input type="date" id="editedDatum" required>
        <label for="editedCas">Čas vypršení:</label>
        <input type="time" id="editedCas" required>
        <label for="editedPriorita">Priorita:</label>
        <input type="text" id="editedPriorita" required>
        <label for="editedHodnoceni">Bodové hodnocení:</label>
        <input type="text" id="editedHodnoceni" required>
        <label for="editedPopis">Popis:</label>
        <textarea id="editedPopis" rows="5" required></textarea>

        <input type="hidden" id="editedTaskId">

        <button type="submit">Uložit</button>
        <button type="button" onclick="closeEditDialog()">Zrušit</button>
    </form>
</div>

<div class="custom-dialog" id="deleteDialog">
    <p>Opravdu chcete smazat úkol?</p>
    <button onclick="confirmDeleteTask5()">Ano</button>
    <button onclick="closeDeleteDialog5()">Zrušit</button>
    
    <input type="hidden" id="deleteID">
</div>

<div class="custom-dialog" id="completeTaskDialog">
    <p>Chcete změnit stav úkolu?</p>
    <button onclick="confirmCompleteTask5()">Ano</button>
    <button onclick="closeCompleteTaskDialog5()">Zrušit</button>
    <!-- Skryté pole pro uchování ID úkolu -->
    <input type="hidden" id="completedTaskId">
</div>

<button id="home-btn" class="home-btn" onclick="window.location.href='homepage.php'">Domů</button>

<script src="skripty77.js"></script>
</body>
</html>

