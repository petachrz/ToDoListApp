<?php
include "prostredi.php";
session_start();

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

// Načtení dat z formuláře
$id_banneru = isset($_POST['id_banneru']) ? $_POST['id_banneru'] : null;

if ($id_banneru) {
    require_once('dbconnect.php'); // Připojení k databázi
    require_once('bezpecnost2.php'); // Funkce pro bezpečné SQL dotazy

    // Smazání záznamu z tabulky uzivatel_banner
    $query1 = "DELETE FROM uzivatel_banner WHERE ID_Uzivatele = ? AND ID_banneru = ?";
    $params1 = ['ii', $userId, $id_banneru];
    secureSQLQuery($conn, $query1, $params1);

    // Smazání záznamu z tabulky banner
    $query2 = "DELETE FROM banner WHERE ID_banneru = ?";
    $params2 = ['i', $id_banneru];
    secureSQLQuery($conn, $query2, $params2);

    echo "Motivace byla úspěšně smazána.";
} else {
    echo "Chyba při mazání motivace.";
}
?>
