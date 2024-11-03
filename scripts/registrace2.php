<?php include "prostredi.php" ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa Úkolů - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div class="form3-container3">
    <div class="form3-column3">
        <h2>Správa Úkolů</h2>

        <form action="spravaUkolu.php" method="post">
            <label for="projectSelect">Vyberte projekt:</label>
            <!-- Vložte kód pro výběr projektu z databáze (select) -->
            <select id="projectSelect" name="projectSelect">
               <option value="projekt1">Projekt 1</option>
               <option value="projekt2">Projekt 1</option>
            </select>

            <button type="submit">Zobrazit úkoly</button>
        </form>

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
                </tr>
            </thead>
            <tbody>
                <!-- Zde můžete generovat řádky tabulky s úkoly -->
                <tr>
                    <td>Úkol 1</td>
                    <td>2023-01-01</td>
                    <td>12:00:00</td>
                    <td>Hotovo</td>
                    <td>1</td>
                    <td>10</td>
                    <td>Popis úkolu 1</td>
                </tr>
                <tr>
                    <td>Úkol 2</td>
                    <td>2023-01-02</td>
                    <td>15:30:00</td>
                    <td>Probíhá</td>
                    <td>2</td>
                    <td>8</td>
                    <td>Popis úkolu 2</td>
                </tr>
                <!-- Další úkoly... -->
            </tbody>
        </table>
    </div>
</div>
<button id="home-btn" class="home-btn" onclick="window.location.href='prostredi.php'">Domů</button>

</body>
</html>
