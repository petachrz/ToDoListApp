<?php
session_start();
include('dbconnect.php');
include('bezpecnost.php');

// Funkce pro zobrazení dialogového okna
function showDialog($message, $success = true) {
    $dialogType = $success ? 'successDialog' : 'errorDialog';
    echo "<script>";
    echo "document.getElementById('$dialogType').style.display = 'block';";
    echo "document.getElementById('dialogMessage').innerText = '$message';";
    echo "</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $surname = sanitizeInput($_POST['surname']);
    $nickname = sanitizeInput($_POST['nickname']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $birthdate = sanitizeInput($_POST['birthdate']); // Přidáno pro datum narození

    // Zkontrolovat shodu hesel
    $passwordConfirmation = sanitizeInput($_POST['password_confirmation']);
    if ($password !== $passwordConfirmation) {
        showDialog("Chyba: Hesla se neshodují.", false);
        exit();
    }

    // Heslo zahashovat před vložením do databáze
    $hashedPassword = hashPassword($password);

    // Přidáním dalších údajů pro tabulku
    $prostrediId = 1; // Předpokládané ID prostředí, můžete upravit dle potřeby

    $query = "INSERT INTO uzivatele (Nickname, Jmeno, Heslo, Prijmeni, Email, Datum_narozeni, Prostredi_ID_Prostredi) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = ['ssssssi', $nickname, $name, $hashedPassword, $surname, $email, $birthdate, $prostrediId];
    $result = secureSQLQuery($conn, $query, $params);

    if ($result) {
        // Úspěšná registrace
        showDialog("Registrace proběhla úspěšně. Nyní se můžete přihlásit.", true);
    } else {
        // Neúspěšná registrace
        showDialog("Chyba při registraci: " . $conn->error, false);
    }
}

$_SESSION['csrf_token'] = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace do To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div class="header">
    <h1>To-Do List</h1>
</div>

<div class="registrace-container">
    <div class="form-column">
        <form method="post" action="registrovani.php">
            <h2>Registrace nového uživatele</h2>
            <!-- ... (váš stávající formulář) ... -->
        </form>
    </div>

    <div class="form-column">
        <h2>&nbsp;</h2>
        <!-- ... (váš stávající formulář) ... -->
    </div>
    
    <h4>&nbsp;</h4>
    <button type="submit">Registrovat se</button>
    </form>

    <div class="login-link">
        Již máte účet? <a href="prihlaseni.php">Přihlášení</a>
    </div>
</div>

<button id="aboutin-btn">O aplikaci</button>
<button id="motivation-btn">Potřebuješ pouze motivaci</button>

<!-- Dialogová okna -->
<div class="custom-dialog" id="successDialog">
    <p id="dialogMessage"></p>
    <button onclick="closeDialog('successDialog')">Zavřít</button>
</div>

<div class="custom-dialog" id="errorDialog">
    <p id="dialogMessage"></p>
    <button onclick="closeDialog('errorDialog')">Zavřít</button>
</div>

<script>
    function closeDialog(dialogId) {
        document.getElementById(dialogId).style.display = 'none';
    }
</script>

</body>
</html>
