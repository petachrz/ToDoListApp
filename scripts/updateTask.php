<?php
include "prostredi.php";
require_once('dbconnect.php');
require_once('bezpecnost2.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = sanitizeInput($_POST['taskId']);
    $nazev = sanitizeInput($_POST['nazev']);
    $datum = sanitizeInput($_POST['datum']);
    $cas = sanitizeInput($_POST['cas']);
    $priorita = sanitizeInput($_POST['priorita']);
    $hodnoceni = sanitizeInput($_POST['hodnoceni']);
    $popis = sanitizeInput($_POST['popis']);

    // Aktualizace úkolu v databázi
    $sql = "UPDATE ukol SET Nazev_ukolu = :nazev, datum_vyprseni = :datum, cas_vyprseni = :cas, priorita = :priorita, bodove_hodnoceni = :hodnoceni, popis = :popis WHERE ID_Ukolu = :taskId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
    $stmt->bindParam(':nazev', $nazev, PDO::PARAM_STR);
    $stmt->bindParam(':datum', $datum, PDO::PARAM_STR);
    $stmt->bindParam(':cas', $cas, PDO::PARAM_STR);
    $stmt->bindParam(':priorita', $priorita, PDO::PARAM_STR);
    $stmt->bindParam(':hodnoceni', $hodnoceni);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>
