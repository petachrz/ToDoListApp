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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aktualizace motivace
    if (isset($_POST['bannerId']) && isset($_POST['editedText'])) {
        $bannerId = sanitizeInput($_POST['bannerId']);
        $editedText = sanitizeInput($_POST['editedText']);

        $updateQuery = "UPDATE banner SET Text = ? WHERE ID_banneru = ? AND EXISTS (SELECT 1 FROM uzivatel_banner WHERE ID_Uzivatele = ? AND ID_banneru = ?)";
        $updateParams = ['siii', $editedText, $bannerId, $userId, $bannerId];
        secureSQLQuery($conn, $updateQuery, $updateParams);
    }

    // Vložení nové motivace
    if (isset($_POST['motivationDescription'])) {
        $newMotivation = sanitizeInput($_POST['motivationDescription']);

        $insertQuery = "INSERT INTO banner (Text) VALUES (?)";
        $insertParams = ['s', $newMotivation];
        $newBannerId = secureSQLInsert($conn, $insertQuery, $insertParams);

        if ($newBannerId) {
            // Přiřazení nové motivace uživateli
            $assignQuery = "INSERT INTO uzivatel_banner (ID_Uzivatele, ID_banneru) VALUES (?, ?)";
            $assignParams = ['ii', $userId, $newBannerId];
            secureSQLQuery($conn, $assignQuery, $assignParams);
        }
    }
}

// Přesměrování zpět na motivace.php
header("Location: motivace.php");
exit();
?>
