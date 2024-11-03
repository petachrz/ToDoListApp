<?php
$servername = ""; 
$username = "";    
$password = "";        
$dbname = "dbtodolist2";     

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Nastavení PDO na výjimky
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Připojení k databázi bylo úspěšné.";
} catch (PDOException $e) {
   // echo "Chyba připojení k databázi: " . $e->getMessage();
}
?>
