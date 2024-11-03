<?php
// nactiukol.php
include "prostredi.php";
require_once('dbconnect.php');

// Funkce pro načtení informací o úkolu podle ID
function getTaskDetails($conn, $taskId) {
    $sql = "SELECT * FROM ukol WHERE ID_Ukolu = :taskId";
    $stmt = $conn->prepare($sql);

  
    $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);

    $stmt->execute();

    // Získání údajů o úkolu
    $taskDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    return $taskDetails;
}

// Získání ID úkolu z POST dat
$taskId = $_POST['taskId'];

// Načtení informací o úkolu
$taskDetails = getTaskDetails($conn, $taskId);

// Vrácení údajů jako JSON
header('Content-Type: application/json');
echo json_encode($taskDetails, JSON_UNESCAPED_UNICODE);
?>
