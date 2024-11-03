// aktualizujmotivaci.php

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
$id = isset($_POST['id']) ? $_POST['id'] : null;
$motivation = isset($_POST['motivation']) ? $_POST['motivation'] : null;

// Aktualizace motivace v databázi
require_once('dbconnect.php'); // Připojení k databázi
require_once('bezpecnost2.php'); // Funkce pro bezpečné SQL dotazy

$query = "UPDATE banner SET Text = ? WHERE ID_banneru = ?";
$params = ['si', $motivation, $id];
$result = secureSQLQuery($conn, $query, $params);

// Uzavření spojení s databází
$conn = null;

// Odpověď serveru (můžete přizpůsobit podle potřeby)
echo "Motivace byla úspěšně aktualizována.";
?>
