<?php
include 'dbconnect.php';
include 'bezpecnost2.php';


// Bezpečné zpracování formulářů
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ošetření vstupů proti XSS
    $safeEmail = sanitizeInput($_POST['email']);
    $safePassword = sanitizeInput($_POST['password']);

    // Bezpečné zpracování SQL dotazu
    $query = "SELECT * FROM uzivatel WHERE Email = ?";
    $params = ['s', $safeEmail];
    $result = secureSQLQuery($conn, $query, $params);

    // Kontrola existence uživatele s daným emailem
    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Ověření hesla
        if (verifyPassword($safePassword, $row['Heslo'])) {
            // Heslo je platné

            // Nastavení cookie po úspěšném přihlášení
            setLoginCookie($row['ID_Uzivatele']);

            // Přesměrování na prostředí.php
            header("Location: homepage.php");
            exit();
        } else {
            // Chyba přihlášení (nesprávné heslo)
            echo "Nesprávné heslo.";
        }
    } else {
        // Chyba přihlášení (uživatel neexistuje)
        echo "Uživatel s tímto emailem neexistuje.";
    }
}

if (isset($_COOKIE['uzivatel_id'])) {
    $uzivatelId = $_COOKIE['uzivatel_id'];
    echo "Hodnota uzivatel_id cookie: $uzivatelId";
    header("Location: homepage.php");
    exit();
} else {
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení do To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div class="header">
    <h1>To-Do List</h1>
</div>

<div class="login-container">
    <h2>Přihlášení</h2>
    <form method="post" action="prihlaseni.php">
        <label for="email">Zadejte platný Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" required>

        <label for="password">Zadejte platné heslo:</label>
        <input type="password" id="password" name="password" placeholder="Heslo" required>

        <button type="submit">Přihlásit se</button>
    </form>
    <div class="register-link">
        Nemáte ještě účet? <a href="registrace.php">Registrujte se!</a>
    </div>
</div>

<button id="aboutin-btn" onclick="window.location.href='oaplikaci.php';">O aplikaci</button>


<!--
<button id="motivation-btn">Potřebujete pouze motivaci</button>
-->
</body>
</html>
