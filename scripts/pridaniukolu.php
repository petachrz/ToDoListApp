<?php
include "prostredi.php";
require_once('dbconnect.php');
require_once('bezpecnost2.php');

$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php");
    exit();
}

$projects = getProjects($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat nový úkol - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>
<div class="form44-container44">
<div class="form44-column44">

<div style="width: 45%; float: left;">

        <form action="zpracujFormular.php" method="post" class="form2-column2">
            <h1>Přidat nový úkol</h1>
            <label for="taskName">Název úkolu:</label>
            <input type="text" id="taskName" name="taskName" required>

            <label for="dueDate">Datum vypršení:</label>
            <input type="date" id="dueDate" name="dueDate" required>

            <label for="dueTime">Čas vypršení:</label>
            <input type="time" id="dueTime" name="dueTime" required>

            <label for="description">Popis:</label>
            <input type="text" id="description" name="description">

        </div>
       
        <div style="width: 45%; float: right;">
        <h4>&nbsp;</h4>
        <label for="category">Výběr projektu:</label>
            <select id="category" name="category" style="margin-bottom: 10px" onchange="toggleNewCategory()">
            <option value="nova">Nový projekt</option>
                <?php
                foreach ($projects as $project) {
                    echo '<option value="' . $project['ID_projektu'] . '">' . $project['Nazev_projektu'] . '</option>';
                }
                ?>
                
            </select>

            <input type="text" id="newCategory" name="newCategory" placeholder="Zadejte novou kategorii" style="margin-bottom: 10px">

            <label for="rating">Bodové hodnocení:</label>
            <input type="number" id="rating" name="rating" required>

            <label for="priority">Priorita:</label>
            <input type="number" id="priority" name="priority" required>

            <button type="submit" style="margin-top: 3px">Přidat úkol</button>
        </form>
    </div>
</div>

<button id="home-btn" class="home-btn" onclick="window.location.href='homepage.php'">Domů</button>

<script src="skripty.js"></script>

</body>
</html>
