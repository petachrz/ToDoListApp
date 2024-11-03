<?php
include 'prostredi.php';
session_start();

// Kontrola přihlášení a získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

// Načtení údajů uživatele z databáze
require_once('dbconnect.php'); // Připojení k databázi
require_once('bezpecnost2.php'); // Funkce pro bezpečné SQL dotazy

$query = "SELECT * FROM uzivatel WHERE ID_Uzivatele = ?";
$params = ['i', $userId];
$result = secureSQLQuery($conn, $query, $params);

if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $nickname = $row['Nickname'];
    $name = $row['Jmeno'];
    $email = isset($row['Email']) ? $row['Email'] : '';
    $password = $row['Heslo'];
    $surname = isset($row['Prijmeni']) ? $row['Prijmeni'] : '';
    $birthdate = isset($row['Datum_narozeni']) ? $row['Datum_narozeni'] : '';
    $notification = $row['notifikace']; // Nové pole "Notifikace"
    // ... další údaje
} else {
    echo "Uživatel nebyl nalezen.";
    exit();
}

// Pokud byl odeslán formulář pro aktualizaci údajů
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
    // Zpracování formuláře a aktualizace údajů v databázi
    $newName = isset($_POST['new_name']) ? $_POST['new_name'] : '';
    $newEmail = isset($_POST['new_email']) ? $_POST['new_email'] : '';
    $newSurname = isset($_POST['new_surname']) ? $_POST['new_surname'] : '';
    $newBirthdate = isset($_POST['new_birthdate']) ? $_POST['new_birthdate'] : '';
    $newNotification = isset($_POST['new_notification']) ? $_POST['new_notification'] : 'ano'; // Defaultní hodnota

    // Ověření, zda jsou nová hesla vyplněna a shodují se
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirmPassword = isset($_POST['new_confirmPassword']) ? $_POST['new_confirmPassword'] : '';

    if (!empty($newPassword) && !empty($confirmPassword)) {
        // Pokud bylo vyplněno alespoň jedno pole, obě musí být vyplněny a shodovat se
        if ($newPassword != $confirmPassword) {
            echo "Nová hesla se neshodují.";
            exit();
        }

        // Případná logika pro aktualizaci hesla
        $hashedPassword = hashPassword($newPassword);

        // Aktualizace hesla v databázi
        $updatePasswordQuery = "UPDATE uzivatel SET Heslo = ? WHERE ID_Uzivatele = ?";
        $updatePasswordParams = ['si', $hashedPassword, $userId];
        secureSQLQuery($conn, $updatePasswordQuery, $updatePasswordParams);
    }

    // Aktualizace zbývajících údajů v databázi
    $updateQuery = "UPDATE uzivatel SET Jmeno = ?, Email = ?, Prijmeni = ?, Datum_narozeni = ?, notifikace = ? WHERE ID_Uzivatele = ?";
    $updateParams = ['sssssi', sanitizeInput($newName), sanitizeInput($newEmail), sanitizeInput($newSurname), sanitizeInput($newBirthdate), sanitizeInput($newNotification), sanitizeInput($userId)];
    secureSQLQuery($conn, $updateQuery, $updateParams);

    // Přesměrování na stejnou stránku pro obnovení
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// HTML kód s automatickým vyplněním údajů
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat nový úkol - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>
<div class="form33-container33">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form2-column2">
        <h2>Správa uživatelského účtu</h2>

        <!-- Část 1 formuláře -->
        <div style="width: 48%; float: left;">
            <label for="nickname">Nickname:</label>
            <input type="text" id="nickname" name="nickname" value="<?php echo $nickname; ?>" readonly>

            <label for="name">Jméno:</label>
            <input type="text" id="name" name="new_name" value="<?php echo $name; ?>" required>

            <label for="password">Nové heslo:</label>
            <input type="password" id="password" name="new_password" placeholder="Zadejte nové heslo">

            <label for="surname">Příjmení:</label>
            <input type="text" id="surname" name="new_surname" value="<?php echo $surname; ?>" required>
        </div>

        <!-- Část 2 formuláře -->
        <div style="width: 48%; float: right;">
            <label for="email">Email:</label>
            <input type="email" id="email" name="new_email" value="<?php echo $email; ?>" required>

            <label for="birthdate">Datum narození:</label>
            <input type="date" id="birthdate" name="new_birthdate" value="<?php echo $birthdate; ?>" required>

            <label for="confirmPassword">Potvrdit nové heslo:</label>
            <input type="password" id="confirmPassword" name="new_confirmPassword" placeholder="Potvrďte své heslo">

          <!--  <label for="notification">Notifikace:</label>
            <select id="notification" name="new_notification" style="margin-right: 50px">
                <option value="ano">Ano</option>
                <option value="ne">Ne</option>
            </select>
        </div>
-->
        <div style="clear: both;"></div>
       

        <button type="submit" name="save_changes">Uložit údaje</button>
    </form>
</div>

<button id="home-btn" class="home-btn" onclick="window.location.href='homepage.php'">Domů</button>

<script src="skripty.js"></script>

</body>
</html>
