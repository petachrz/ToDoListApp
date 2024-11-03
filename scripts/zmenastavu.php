<?php
// Připojení k databázi a inicializace proměnní

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

include "dbconnect.php";
$taskId = $_POST['taskId'];

// Získání aktuálního stavu úkolu
$sql = "SELECT stav_ukolu FROM ukol WHERE ID_Ukolu = :taskId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
$stmt->execute();
$currentStatus = $stmt->fetchColumn();

// Přepnutí stavu úkolu (změna 0 na 1 nebo 1 na 0)
$newStatus = $currentStatus === 0 ? 1 : 0;

// Aktualizace stavu úkolu v databázi
$sqlUpdate = "UPDATE ukol SET stav_ukolu = :newStatus WHERE ID_Ukolu = :taskId";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
$stmtUpdate->bindParam(':taskId', $taskId, PDO::PARAM_INT);

// Vykonání aktualizace
if ($stmtUpdate->execute()) {
    // Úspěšné přepnutí stavu úkolu
    echo 'success';
} else {
    // Chyba při přepínání stavu úkolu
    echo 'error';
}
?>
