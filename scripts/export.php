<?php
include "prostredi.php";
require_once('dbconnect.php');
require_once('bezpecnost2.php');
require 'vendor/autoload.php'; // Načtěte autoload.php pro PhpSpreadsheet

// Získání ID uživatele z cookies
$userId = isset($_COOKIE['uzivatel_id']) ? $_COOKIE['uzivatel_id'] : null;

// Pokud není uživatel přihlášen, přesměruj na přihlašovací stránku
if (!$userId) {
    header("Location: prihlaseni.php");
    exit();
}

// Získání seznamu projektů
$projects = getProjects($conn);

// Inicializace proměnné pro název vybraného projektu
$selectedProjectName = '';

// Zpracování formuláře
if (isset($_POST['exportTasks'])) {
    // Získání vybraného ID projektu z formuláře
    $selectedProjectID = isset($_POST['projectSelect']) ? $_POST['projectSelect'] : null;

    // Získání názvu vybraného projektu
    if ($selectedProjectID) {
        foreach ($projects as $project) {
            if ($project['ID_projektu'] == $selectedProjectID) {
                $selectedProjectName = $project['Nazev_projektu'];
                break;
            }
        }

        // Načtení úkolů pod vybraným projektem
        $tasks = getTasksByProject100($conn, $selectedProjectID);

        // Export úkolů do Excelu
        exportToExcel($tasks, $selectedProjectName);
    } else {
        // Zpracování chyby nevybrání projektu
        echo "Prosím, vyberte projekt.";
    }
} else {
    // Pokud není vybrán projekt, můžete načíst výchozí nebo zobrazit žádné úkoly
    $tasks = array(); // nebo jiná výchozí hodnota
}

function exportToExcel($tasks, $projectName) {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $boldStyle = [
        'font' => ['bold' => true],
    ];
    
    $sheet->getStyle('B2')->applyFromArray($boldStyle);
    $sheet->getStyle('C2')->applyFromArray($boldStyle);
    $sheet->getStyle('B4:J4')->applyFromArray($boldStyle);

    // Nastavte hlavičky
    $sheet->setCellValue('B2', 'Název projektu');
    $sheet->setCellValue('C2', $projectName);
    
    $sheet->setCellValue('B4', 'Název úkolu');
    $sheet->setCellValue('C4', 'Datum vytvoření');
    $sheet->setCellValue('D4', 'Čas vytvoření');
    $sheet->setCellValue('E4', 'Datum vypršení');
    $sheet->setCellValue('F4', 'Čas vypršení');
    $sheet->setCellValue('G4', 'Stav úkolu');
    $sheet->setCellValue('H4', 'Priorita');
    $sheet->setCellValue('I4', 'Bodové hodnocení');
    $sheet->setCellValue('J4', 'Popis');

    // Naplnění řádků daty
    $row = 5;
    foreach ($tasks as $task) {
        $sheet->setCellValue('B' . $row, $task['Nazev_ukolu']);
        $sheet->setCellValue('C' . $row, $task['datum_vytvoreni']);
        $sheet->setCellValue('D' . $row, $task['cas_vytvoreni']);
        $sheet->setCellValue('E' . $row, $task['datum_vyprseni']);
        $sheet->setCellValue('F' . $row, $task['cas_vyprseni']);
        
        $stavUkolu = $task['stav_ukolu'];
        $stavText = ($stavUkolu == 1) ? 'Splněno' : 'Nesplněno';
        $sheet->setCellValue('G' . $row, $stavText);

        $sheet->setCellValue('H' . $row, $task['priorita']);
        $sheet->setCellValue('I' . $row, $task['bodove_hodnoceni']);
        $sheet->setCellValue('J' . $row, $task['popis']);
        $row++;
    }

    // Uložení do souboru
    $filename = 'projekt_' . $projectName . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);

    // Poskytnutí souboru ke stažení
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - To-Do List Aplikace</title>
    <link rel="stylesheet" href="styly.css">
</head>
<body>

<div class="homepage-container">
    <div class="homepage-column">
        <h1>Exportovat seznam ve formátu XLSX</h1>

        <!-- Formulář pro výběr projektu -->
        <form method="post" action="">
            <select id="projectSelect" name="projectSelect">
                <?php
                foreach ($projects as $project) {
                    echo '<option value="' . $project['ID_projektu'] . '">' . $project['Nazev_projektu'] . '</option>';
                }
                ?>
            </select>
            <button type="submit" name="exportTasks">Exportovat</button>
        </form>

        </div>
</div>
<button id="home-btn" class="home-btn" onclick="window.location.href='homepage.php'">Domů</button>

<div class="image-container">
    <img src="images/todolistobrazek.png" alt="Image 1" class="left-image">
    <img src="images/todolistobrazek.png" alt="Image 2" class="right-image">
</div>

<script src="skripty.js"></script> 


</body>
</html>
