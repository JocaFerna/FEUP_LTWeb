<?php
if (!isset($_POST['username'])) {
    http_response_code(400); 
    exit("Error: Username parameter is missing.");
}
if (!file_exists('./database/LTW.db')) {
    error_log('SQLite database file does not exist.');
} elseif (!is_readable('./database/LTW.db')) {
    error_log('SQLite database file is not readable.');
}

$username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try {
    $db = new PDO('sqlite:../database/LTW.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare('UPDATE Users SET isBanned = 1 WHERE username = :username');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    http_response_code(500); 
    exit('Error: ' . $e->getMessage());
}

