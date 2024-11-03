<?php
function connectToDatabase() {
    global $conn; 

    // Kontrola připojení
    if (!$conn) {
        die('Chyba při připojování k databázi.');
    }

    return $conn;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div id="mySidebar" class="sidebar">
  
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"> <- Zpět </a>
  <a href="pridaniukolu.php">Přidat úkol</a>
  <a href="spravaukolu.php">Správa úkolů</a>
  <a href="#"></a>
  <a href="#"></a>
  <a href="#"></a>
  <a href="#"></a>
  <a href="motivace.php">Motivace</a>
  <a href="export.php">Export</a>
  <a href="nastaveni.php">Správa účtu</a>
  <a href="oaplikaci.php">O aplikaci</a>
</div>

<div class="header">
    <h1>To-Do List</h1>
</div>

<button class="openbtn" onclick="openNav()">☰ Menu</button>

<script src="skripty.js"></script>

<form method="post" action="odhlaseni.php">
    <button type="submit" name="logout-btn" id="logout-btn">Odhlásit se</button>
</form>

<div class="control-panel">
    <a href="spravaukolu.php" class="panel-btn">Správa úkolů</a>
    <a href="pridaniukolu.php" class="panel-btn">Přidat nový úkol</a>
    <a href="motivace.php" class="panel-btn">Motivace</a>
</div>

</body>
</html>
