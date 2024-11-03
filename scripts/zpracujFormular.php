<?php
require_once('dbconnect.php');
require_once('bezpecnost2.php');

echo '<pre>';
print_r($_POST);
echo '</pre>';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskName = isset($_POST["taskName"]) ? $_POST["taskName"] : null;
    $dueDate = isset($_POST["dueDate"]) ? $_POST["dueDate"] : null;
    $dueTime = isset($_POST["dueTime"]) ? $_POST["dueTime"] : null;
    $priority = isset($_POST["priority"]) ? $_POST["priority"] : null;
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : null;
    $description = isset($_POST["description"]) ? $_POST["description"] : null;
    $category = isset($_POST["category"]) ? $_POST["category"] : null;


    $projectId = $category;
    echo "Vybraný projekt: $projectId"; 
    if ($projectId == "nova") {
        $newProjectName = isset($_POST["newCategory"]) ? $_POST["newCategory"] : null;
    
        if ($newProjectName) {
            // Přidání nového projektu
            $insertProjectQuery = "INSERT INTO projekt (Nazev_projektu, pocet_ukolu, pocet_splnenych_ukolu, pocet_nesplnenych_ukolu, prumerna_doba_plneni) VALUES (?, 1, 0, 0, 0)";
            
            $stmt = $conn->prepare($insertProjectQuery);
            if (!$stmt) {
                // Zachycení chyby
                exit("Chyba při přípravě dotazu: " . $conn->errorInfo()[2]);
            }

            // Zde přidáme další kontrolu chyby při vykonávání dotazu
            if (!$stmt->execute([sanitizeInput($newProjectName)])) {
                exit("Chyba při vkládání nového projektu: " . $stmt->errorInfo()[2]);
            }
    
            $projectId = $conn->lastInsertId();
        } else {
            // Handle error or redirect back to the form with an error message
            exit("Chyba: Nový projekt vyžaduje název.");
        }
    }
    
    // Přidání nového úkolu
    $insertTaskQuery = "INSERT INTO ukol (Nazev_ukolu, datum_vytvoreni, cas_vytvoreni, datum_vyprseni, cas_vyprseni, stav_ukolu, doba_plneni, priorita, bodove_hodnoceni, popis, Projekt_ID_projektu) VALUES (?, CURDATE(), CURTIME(), ?, ?, 0, 0, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertTaskQuery);

    // Další kontrola chyby
    if (!$stmt) {
        exit("Chyba při přípravě dotazu pro vkládání úkolu: " . $conn->errorInfo()[2]);
    }

    if (!$stmt->execute([sanitizeInput($taskName), sanitizeInput($dueDate), sanitizeInput($dueTime), sanitizeInput($priority), sanitizeInput($rating), sanitizeInput($description), sanitizeInput($projectId)])) {
        exit("Chyba při vkládání úkolu: " . $stmt->errorInfo()[2]);
    }

   header("Location: homepage.php");
   exit();
}
?>
