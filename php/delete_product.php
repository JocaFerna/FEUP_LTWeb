<?php
if (!isset($_POST['id'])) {
    http_response_code(400); 
    exit("Error: Id parameter is missing.");
}
if (!file_exists('../database/LTW.db')) {
    error_log('SQLite database file does not exist.');
} elseif (!is_readable('../database/LTW.db')) {
    error_log('SQLite database file is not readable.');
}

$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

try {
    $db = new PDO('sqlite:../database/LTW.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("DELETE FROM Product WHERE id =:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    http_response_code(500); 
    exit('Error: ' . $e->getMessage());
}
