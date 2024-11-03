<?php
// prostredi.php
include 'bezpecnost2.php';

function getUserDataById($conn, $uzivatel_id) {
    // Funkce načte údaje o uživateli z databáze na základě ID
    
    $query = "SELECT * FROM uzivatel WHERE ID_Uzivatele = ?";
    $params = ['i', $uzivatel_id];
    
    $result = secureSQLQuery($conn, $query, $params);

    if ($result->rowCount() > 0) {
        return $result->fetch(PDO::FETCH_ASSOC);
    } else {
        return null; // Uživatel s daným ID nenalezen
    }
}
?>
