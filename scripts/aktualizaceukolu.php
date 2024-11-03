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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání hodnot z POST požadavku
    $taskId = sanitizeInput($_POST['taskID']);  // Adjusted key name
    $editedNazev = sanitizeInput($_POST['editedNazev']);
    $editedDatum = sanitizeInput($_POST['editedDatum']);
    $editedCas = sanitizeInput($_POST['editedCas']);
    $editedPriorita = sanitizeInput($_POST['editedPriorita']);
    $editedHodnoceni = sanitizeInput($_POST['editedHodnoceni']);
    $editedPopis = sanitizeInput($_POST['editedPopis']);

    // Aktualizace úkolu v databázi
    $sql = "UPDATE ukol 
            SET Nazev_ukolu = :editedNazev, 
                datum_vyprseni = :editedDatum, 
                cas_vyprseni = :editedCas, 
                priorita = :editedPriorita, 
                bodove_hodnoceni = :editedHodnoceni, 
                popis = :editedPopis 
            WHERE ID_Ukolu = :taskID";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':editedNazev', $editedNazev, PDO::PARAM_STR);
    $stmt->bindParam(':editedDatum', $editedDatum, PDO::PARAM_STR);
    $stmt->bindParam(':editedCas', $editedCas, PDO::PARAM_STR);
    $stmt->bindParam(':editedPriorita', $editedPriorita, PDO::PARAM_STR);
    $stmt->bindParam(':editedHodnoceni', $editedHodnoceni, PDO::PARAM_STR);
    $stmt->bindParam(':editedPopis', $editedPopis, PDO::PARAM_STR);
    $stmt->bindParam(':taskID', $taskId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Aktualizace úkolu byla úspěšná.";
    } catch (PDOException $e) {
        echo "Chyba při aktualizaci úkolu: " . $e->getMessage();
    }
} else {
    echo "Neplatný požadavek.";
}
?>
