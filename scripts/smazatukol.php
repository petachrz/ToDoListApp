<?php
include "dbconnect.php";
// Připojení k databázi a inicializace proměnní

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

$taskId = $_POST['taskId'];

// Smazání úkolu z databáze
$sqlDelete = "DELETE FROM ukol WHERE ID_Ukolu = :taskId";
$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bindParam(':taskId', $taskId, PDO::PARAM_INT);

// Vykonání smazání
if ($stmtDelete->execute()) {
    // Úspěšné smazání úkolu
    echo 'success';
} else {
    // Chyba při mazání úkolu
    echo 'error';
}
?>
