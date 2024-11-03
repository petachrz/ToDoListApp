
function completeTask5(taskId) {
    // Zde můžete přidat kód pro zobrazení dialogového okna po dokončení úkolu
    document.getElementById('completeTaskDialog').style.display = 'block';

    // Nastavení ID úkolu pro pozdější použití při potvrzení
    document.getElementById('completedTaskId').value = taskId;
}

function confirmCompleteTask5() {
    // Získání ID úkolu
    var taskId = document.getElementById('completedTaskId').value;

    // AJAX volání pro přepnutí stavu úkolu v databázi
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'zmenastavu.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Vytvoření dat pro odeslání na server (ID úkolu)
    var data = 'taskId=' + taskId;

    // Definování reakce na úspěšné provedení AJAX volání
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Úspěšné přepnutí stavu úkolu
            // Zavření dialogového okna po potvrzení aktualizace
            closeCompleteTaskDialog5();
            // Aktualizace tabulky úkolů na stránce (volání funkce pro načtení úkolů)
            location.reload();
        } else {
            // Chyba při přepínání stavu úkolu
            alert('Chyba při přepínání stavu úkolu.');
        }
    };

    // Odeslání AJAX požadavku na server
    xhr.send(data);
}

function editTask5(taskId, taskName, taskDate, taskTime, taskPriority, taskRating, taskDescription) {
    // Log the task ID for debugging
    console.log('Editing task with ID:', taskId, taskName, taskDate, taskTime, taskPriority, taskRating, taskDescription);

    // Fill the form fields in the edit dialog with the task details
    document.getElementById('editedTaskId').value = taskId;

    document.getElementById('editedNazev').value = taskName;
    document.getElementById('editedDatum').value = taskDate;
    document.getElementById('editedCas').value = taskTime;
    document.getElementById('editedPriorita').value = taskPriority;
    document.getElementById('editedHodnoceni').value = taskRating;
    document.getElementById('editedPopis').value = taskDescription;

    // Open the edit dialog
    document.getElementById('editDialog').style.display = 'block';
}

function deleteTask5(taskId) {
    // Zde můžete přidat kód pro zobrazení dialogového okna po dokončení úkolu
    document.getElementById('deleteDialog').style.display = 'block';

    // Nastavení ID úkolu pro pozdější použití při potvrzení
    document.getElementById('deleteID').value = taskId;
}

function closeEditDialog() {
    document.getElementById('editDialog').style.display = 'none';
}

function saveEditedTask5() {
    // Get values from the edited task form
    var taskID = document.getElementById('editedTaskId').value;
    var editedNazev = document.getElementById('editedNazev').value;
    var editedDatum = document.getElementById('editedDatum').value;
    var editedCas = document.getElementById('editedCas').value;
    var editedPriorita = document.getElementById('editedPriorita').value;
    var editedHodnoceni = document.getElementById('editedHodnoceni').value;
    var editedPopis = document.getElementById('editedPopis').value;

    // Log the values for debugging
    console.log('Edited ID úkolu:', taskID);
    console.log('Edited Název úkolu:', editedNazev);
    console.log('Edited Datum vypršení:', editedDatum);
    console.log('Edited Čas vypršení:', editedCas);
    console.log('Edited Priorita:', editedPriorita);
    console.log('Edited Bodové hodnocení:', editedHodnoceni);
    console.log('Edited Popis:', editedPopis);

    // Add any additional logic for saving the edited task, if needed
    var postData = 'taskID=' + encodeURIComponent(taskID) +
                   '&editedNazev=' + encodeURIComponent(editedNazev) +
                   '&editedDatum=' + encodeURIComponent(editedDatum) +
                   '&editedCas=' + encodeURIComponent(editedCas) +
                   '&editedPriorita=' + encodeURIComponent(editedPriorita) +
                   '&editedHodnoceni=' + encodeURIComponent(editedHodnoceni) +
                   '&editedPopis=' + encodeURIComponent(editedPopis);

    // AJAX pro odeslání dat na server pro aktualizaci v databázi
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'aktualizaceukolu.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Zpracování odpovědi serveru, pokud je třeba
            console.log(xhr.responseText);
        }
    };

    // Odeslání dat na server
    xhr.send(postData);


    // Close the edit dialog
    closeEditDialog();
    location.reload();
}

function confirmDeleteTask5() {
    // Získání ID úkolu
    var taskId = document.getElementById('deleteID').value;

    // Vypsání ID úkolu do konzole pro ladění
    console.log('Potvrzeno smazání úkolu s ID:', taskId);

    // Vytvoření AJAX objektu
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'smazatukol.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Vytvoření dat pro odeslání na server (ID úkolu)
    var data = 'taskId=' + encodeURIComponent(taskId);

    // Definování reakce na úspěšné provedení AJAX volání
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Úspěšné smazání úkolu
            // Zavření dialogového okna po potvrzení smazání
            closeDeleteDialog5();
            // Aktualizace tabulky úkolů na stránce (volání funkce pro načtení úkolů)
            location.reload();
        } else {
            // Chyba při mazání úkolu
            alert('Chyba při mazání úkolu.');
        }
    };

    // Odeslání AJAX požadavku na server
    xhr.send(data);
}


function closeDeleteDialog5() {
    document.getElementById('deleteDialog').style.display = 'none';
}

function closeCompleteTaskDialog5() {
    document.getElementById('completeTaskDialog').style.display = 'none';
}

function loadMotivation() {
    // Vytvoření objektu XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Nastavení cesty k souboru homepagemotivace.php
    xhr.open("GET", "homepagemotivace.php", true);

    // Nastavení obsluhy události pro zpracování odpovědi
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Získání odpovědi a aktualizace obsahu motivace
            document.getElementById("motivationText").innerHTML = xhr.responseText;
        }
    };

    // Odeslání žádosti
    xhr.send();
}