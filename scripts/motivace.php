<?php
include "prostredi.php";
session_start();

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

// Načtení dat z databáze
require_once('dbconnect.php'); // Připojení k databázi
require_once('bezpecnost2.php'); // Funkce pro bezpečné SQL dotazy

// SQL dotaz pro načtení textů motivací spojených s přihlášeným uživatelem
$query = "SELECT b.ID_banneru, b.Text FROM banner b
          JOIN uzivatel_banner ub ON b.ID_banneru = ub.ID_banneru
          WHERE ub.ID_Uzivatele = ?";
$params = ['i', $userId];
$result = secureSQLQuery($conn, $query, $params);

$bannerTexts = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $bannerTexts[] = $row;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- motivace.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivační texty - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>
<div class="form2-container2">
    <div class="form2-column2">
        <h2>Vaše motivační texty</h2>

        
<div class="motivation-list">
    <?php foreach ($bannerTexts as $bannerText): ?>
        <div class="motivation-item">
            <div class="motivation-content">
                <span class="motivation-description"><?php echo $bannerText['Text']; ?></span>
                <div class="motivation-buttons">
                    <i class="fas fa-edit" onclick="openEditDialog('<?php echo $bannerText['ID_banneru']; ?>', '<?php echo $bannerText['Text']; ?>')"></i>
                    <i class="fas fa-trash" onclick="showDeleteDialog('<?php echo isset($bannerText['ID_banneru']) ? $bannerText['ID_banneru'] : ''; ?>')"></i>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

           
        </div>
    </div>

    <div class="form2-column2">
        <h2>Přidání nového motivačního textu</h2>

        <form action="zpracujmotivaci.php" method="post">
            <textarea id="motivationDescription" name="motivationDescription" rows="15" style="resize: none; width: 100%;" class="motivation-textarea" required placeholder="Sem napište svou motivaci..."></textarea>
            <button type="submit">Přidat</button>
        </form>
    </div>
</div>

<div class="custom-dialog" id="deleteDialog">
    <p>Opravdu chcete smazat tento motivační text?</p>
    <button onclick="deleteMotivation()">Ano</button>
    <button onclick="closeDialog()">Zrušit</button>
</div>

<div class="custom-dialog" id="editDialog">
    <h3>Upravit text</h3>
    <form id="editForm" onsubmit="saveEditedMotivation(); return false;">
        <textarea id="editedMotivationDescription" name="editedMotivationDescription" rows="5" style="resize: none; width: 100%;" class="motivation-textarea" required></textarea>
        <button type="submit">Uložit</button>
        <button type="button" onclick="closeEditDialog()">Zrušit</button>
    </form>
</div>

<button id="home-btn" class="home-btn" onclick="window.location.href='homepage.php'">Domů</button>

<script src="skripty22.js"></script>
</body>
</html>
</body>
</html>