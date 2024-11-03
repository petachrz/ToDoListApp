<?php
require_once('bezpecnost2.php');
require_once('dbconnect.php');

$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

if (!$userId) {
    header("Location: prihlaseni.php"); // Přesměrování na přihlašovací stránku
    exit();
}

// SQL dotaz pro načtení všech motivacních textů
$query = "SELECT banner.Text
FROM banner
INNER JOIN uzivatel_banner ON banner.ID_banneru = uzivatel_banner.ID_banneru
WHERE uzivatel_banner.ID_Uzivatele = :userId
ORDER BY RAND()
LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Vrácení náhodného textu jako odpovědi
echo $result['Text'];

?>
