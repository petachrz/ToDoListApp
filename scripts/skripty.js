
function openNav() {
  document.getElementById("mySidebar").style.width = "200px";
  document.getElementById("main").style.marginLeft = "200px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

function showAddTaskForm() {
  document.getElementById("addTaskForm").style.display = "block";
}

// skripty.js
function toggleNewCategory() {
  var categorySelect = document.getElementById("category");
  var newCategoryInput = document.getElementById("newCategory");

  if (categorySelect.value === "nova") {
      newCategoryInput.style.display = "block";
      // Nastavíme hodnotu pole "category" na "nova" při výběru nového projektu
      document.getElementById("category").value = "nova";
  } else {
      newCategoryInput.style.display = "none";
      // Nastavíme hodnotu pole "category" na hodnotu vybraného projektu
      document.getElementById("category").value = categorySelect.value;
  }
}

function enableEdit(button) {
var motivationItem = button.closest(".motivation-item");
var isEditable = motivationItem.classList.contains("editing");

if (!isEditable) {
  motivationItem.classList.add("editing");
} else {
  motivationItem.classList.remove("editing");
}

motivationItem.contentEditable = !isEditable;
button.textContent = isEditable ? "Upravit" : "Uložit";
}

function showDeleteDialog(button) {
var deleteDialog = document.getElementById("deleteDialog");
deleteDialog.style.display = "block";
deleteDialog.dataset.motivationItem = button.closest(".motivation-item");
}

function deleteMotivation() {
var deleteDialog = document.getElementById("deleteDialog");
var motivationItem = deleteDialog.dataset.motivationItem;

// Pro účely ukázky pouze odebereme motivaci ze seznamu
motivationItem.remove();

closeDialog();
}

function closeDialog() {
var deleteDialog = document.getElementById("deleteDialog");
deleteDialog.style.display = "none";
deleteDialog.dataset.motivationItem = null;
}

function openEditDialog(button) {
var editDialog = document.getElementById("editDialog");
var editedMotivationDescription = document.getElementById("editedMotivationDescription");

var motivationItem = button.closest(".motivation-item");
editedMotivationDescription.value = motivationItem.querySelector(".motivation-description").textContent;

editDialog.dataset.motivationItem = motivationItem;
editDialog.style.display = "block";
}

function saveEditedMotivation() {
var editDialog = document.getElementById("editDialog");
var motivationItem = editDialog.dataset.motivationItem;
var editedMotivationDescription = document.getElementById("editedMotivationDescription").value;

motivationItem.querySelector(".motivation-description").textContent = editedMotivationDescription;

closeEditDialog();
}

function closeEditDialog() {
var editDialog = document.getElementById("editDialog");
editDialog.style.display = "none";
editDialog.dataset.motivationItem = null;
}

/** */
function editTask(row) {
// Zde můžete otevřít vlastní dialogové okno pro úpravu úkolu
var dialog = document.getElementById('editDialog');
var cells = row.parentNode.parentNode.cells;

// Předvyplnění hodnotami
document.getElementById('editedNazev').value = cells[0].innerText;
document.getElementById('editedDatum').value = cells[1].innerText;
document.getElementById('editedCas').value = cells[2].innerText;
document.getElementById('editedPriorita').value = cells[3].innerText;
document.getElementById('editedHodnoceni').value = cells[4].innerText;
document.getElementById('editedPopis').value = cells[5].innerText;

// Zobrazení dialogového okna
dialog.style.display = 'block';
}

function deleteTask(row) {
// Zde můžete otevřít vlastní dialogové okno pro potvrzení smazání úkolu
var dialog = document.getElementById('deleteDialog');
var cells = row.parentNode.parentNode.cells;

// Předvyplnění hodnotou pro potvrzení
document.getElementById('taskToDelete').innerText = cells[0].innerText;

// Zobrazení dialogového okna
dialog.style.display = 'block';
}

function closeEditDialog() {
// Zavření dialogového okna pro úpravu
document.getElementById('editDialog').style.display = 'none';
}

function closeDeleteDialog() {
// Zavření dialogového okna pro smazání
document.getElementById('deleteDialog').style.display = 'none';
}

function confirmDeleteTask() {
// Zde byste měli provést akci smazání úkolu, např. odeslat AJAX požadavek na server
// Po smazání můžete aktualizovat tabulku nebo provést další akce podle vašich potřeb
var taskName = document.getElementById('taskToDelete').innerText;
alert("Úkol " + taskName + " byl smazán.");

// Zavření dialogového okna pro smazání
closeDeleteDialog();
}
function completeTask(row) {
// Zde můžete implementovat akci označení úkolu jako splněného
// Můžete poslat AJAX požadavek na server nebo provést jinou akci podle vašich potřeb

// Zobrazení dialogového okna
document.getElementById("completeTaskDialog").style.display = "block";
}

function closeCompleteTaskDialog() {
// Zavření dialogového okna
document.getElementById("completeTaskDialog").style.display = "none";
}

// skripty.js

// Funkce pro načítání úkolů
function loadTasks() {
var projectSelect = document.getElementById("projectSelect");
var selectedProject = projectSelect.options[projectSelect.selectedIndex].value;

// Zde můžete implementovat načítání úkolů podle vybraného projektu
// Můžete poslat AJAX požadavek na server nebo provést jinou akci podle vašich potřeb

// Příklad: Zobrazení fiktních úkolů
var taskList = document.getElementById("taskList");
taskList.innerHTML = ""; // Vyčištění seznamu

for (var i = 1; i <= 5; i++) {
  var taskItem = document.createElement("li");
  taskItem.textContent = "Úkol " + i + " pro " + selectedProject;
  taskList.appendChild(taskItem);
}
}

// Funkce pro načítání motivace
function loadMotivation() {
// Zde můžete implementovat načítání motivace
// Můžete poslat AJAX požadavek na server nebo provést jinou akci podle vašich potřeb

// Příklad: Zobrazení fiktního motivujícího textu
var motivationText = document.getElementById("motivationText");
motivationText.textContent = "Jsem silný, schopný a dokážu dosáhnout svých cílů!";
}
function closeDialogAndRedirect(redirectUrl) {
closeDialog();
window.location.href = redirectUrl;
}

function closeDialog() {
var successDialog = document.getElementById('successDialog');
var errorDialog = document.getElementById('errorDialog');

if (successDialog) {
  successDialog.style.display = 'none';
}

if (errorDialog) {
  errorDialog.style.display = 'none';
}
}


