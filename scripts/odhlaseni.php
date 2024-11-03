<?php
include 'bezpecnost2.php';

function logout() {
    // Zrušení session
    session_start();
    session_unset();
    session_destroy();

    // Smazání cookie s uzivatel_id
    setcookie('uzivatel_id', '', time() - 3600, '/');

    // Přesměrování na přihlašovací stránku nebo jinou stránku dle potřeby
    header("Location: prihlaseni.php");
    exit();
}

logout();
?>
