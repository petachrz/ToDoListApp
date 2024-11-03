<?php

// Ochrana proti XSS útokům
function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Ochrana před SQL injection
function secureSQLQuery($conn, $query, $params) {
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Chyba při přípravě dotazu.');
    }

    // Bind parametry
    if (!empty($params)) {
        $paramTypes = str_split(array_shift($params));
        $paramValues = $params;

        foreach ($paramTypes as $index => $type) {
            $stmt->bindValue($index + 1, $paramValues[$index], getTypeConstant($type));
        }
    }

    if (!$stmt->execute()) {
        die('Chyba při provádění dotazu: ' . print_r($stmt->errorInfo(), true));
    }

    // Vrátit výsledek metody execute
    return $stmt;
}

function secureSQLInsert($conn, $query, $params) {
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Chyba při přípravě dotazu: ' . $conn->errorInfo()[2]);
    }

    // Bind parametry
    if (!empty($params)) {
        $paramTypes = str_split(array_shift($params));
        $paramValues = $params;

        foreach ($paramTypes as $index => $type) {
            $stmt->bindValue($index + 1, $paramValues[$index], getTypeConstant($type));
        }
    }

    if (!$stmt->execute()) {
        die('Chyba při provádění dotazu: ' . $stmt->errorInfo()[2]);
    }

    // Vrátit ID nově vloženého záznamu
    return $conn->lastInsertId();
}

// Funkce pro získání konstanty typu proměnné
function getTypeConstant($type) {
    switch ($type) {
        case 'i':
            return PDO::PARAM_INT;
        case 'd':
            return PDO::PARAM_STR;
        case 's':
        default:
            return PDO::PARAM_STR;
    }
}

// Šifrování hesel
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Ověření hesla
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Ochrana proti CSRF útokům - generování a ověření tokenů
function generateCSRFToken() {
    return bin2hex(random_bytes(32));
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function isDuplicate($conn, $nickname, $email) {
    // Kontrola existence uživatele s daným přezdívkou nebo e-mailem
    $checkQuery = "SELECT * FROM uzivatel WHERE Nickname = ? OR Email = ?";
    $checkParams = ['ss', $nickname, $email];
    $checkResult = secureSQLQuery($conn, $checkQuery, $checkParams);

    return $checkResult->rowCount() > 0;
}

// Zabezpečení session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Funkce pro nastavení cookie
function setLoginCookie($userId) {
    $expiry = time() + 3600; // Cookie platné po dobu jedné hodiny (3600 sekund)
    setcookie('uzivatel_id', $userId, $expiry, '/');
}
function getProjects($conn) {
    $projects = array();
    $result = $conn->query("SELECT * FROM projekt");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $projects[] = $row;
    }
    return $projects;
}

// Funkce pro načítání úkolů pod daným projektem
function getTasksByProject($conn, $projectID) {
    $sql = "SELECT * FROM ukol WHERE Projekt_ID_projektu = :projectID AND stav_ukolu = 0 ORDER BY datum_vyprseni ASC, cas_vyprseni ASC, priorita ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':projectID', $projectID, PDO::PARAM_INT);
    $stmt->execute();

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}

// Funkce pro načtení úkolů podle ID projektu
function getTasksByProject100($conn, $projectID) {
    $sql = "SELECT * FROM ukol WHERE Projekt_ID_projektu = :projectID";
    $stmt = $conn->prepare($sql);

    // Bind parametry
    $stmt->bindParam(':projectID', $projectID, PDO::PARAM_INT);

    // Vykonání dotazu
    $stmt->execute();

    $tasks = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tasks[] = $row;
    }

    return $tasks;
}

function getCompletedTasksByUser($conn, $userId) {
    $sql = "SELECT * FROM ukol WHERE uzivatel_id = :userId AND stav_ukolu = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $completedTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $completedTasks;
}

?>
