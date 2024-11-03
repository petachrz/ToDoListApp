function openEditDialog(bannerId, bannerText) {
    document.getElementById('editedMotivationDescription').value = bannerText;
    document.getElementById('editDialog').style.display = 'block';
    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
        saveEditedMotivation(bannerId);
    });
}

function saveEditedMotivation(bannerId) {
    var editedText = document.getElementById('editedMotivationDescription').value;

    // AJAX pro odeslání dat na server pro aktualizaci v databázi
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'zpracujmotivaci.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log('Motivace byla aktualizována v databázi');
            // Obnovit stránku po uložení motivace
            location.reload();
        }
    };
    xhr.send('bannerId=' + encodeURIComponent(bannerId) + '&editedText=' + encodeURIComponent(editedText));
}
function closeEditDialog() {
    document.getElementById('editDialog').style.display = 'none';
}
function showDeleteDialog(id_banneru) {
    var deleteDialog = document.getElementById("deleteDialog");

    // Přidáme kontrolu, zda byl prvek s ID "deleteDialog" nalezen
    if (!deleteDialog) {
        console.error("Element s ID 'deleteDialog' nebyl nalezen.");
        return;
    }

    deleteDialog.style.display = "block";

    var deleteButton = deleteDialog.querySelector("button");

    // Přidáme kontrolu, zda byl prvek <button> nalezen
    if (deleteButton) {
        deleteButton.addEventListener("click", function () {
            deleteMotivation(id_banneru);
        });
    } else {
        console.error("Prvek <button> v deleteDialog nebyl nalezen.");
    }
}


    function deleteMotivation(id_banneru) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "smazatmotivaci.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Případně můžete přidat další akce po úspěšném smazání
                location.reload(); // Např. obnovení stránky
            }
        };
        xhr.send("id_banneru=" + id_banneru);
    }

    function closeDialog(){
        document.getElementById('deleteDialog').style.display = 'none';
    }

    function completeTask(taskId) {
        // Implementace akce pro označení úkolu jako splněného
        console.log('Complete task with ID: ' + taskId);
    }
    
    function editTask(taskId) {
        // Implementace akce pro editaci úkolu
        console.log('Edit task with ID: ' + taskId);
    }
    
    function deleteTask(taskId) {
        // Implementace akce pro smazání úkolu
        console.log('Delete task with ID: ' + taskId);
    }
    