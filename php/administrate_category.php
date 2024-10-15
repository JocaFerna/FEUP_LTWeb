<?php
if (!isset($_POST['id'])|| !isset($_POST['type'])) {
    http_response_code(400); 
    exit("Error: Parameter is missing.");
}
if (!file_exists('../database/LTW.db')) {
    error_log('SQLite database file does not exist.');
} elseif (!is_readable('../database/LTW.db')) {
    error_log('SQLite database file is not readable.');
}

$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
$type = filter_var($_POST['type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$type = ucfirst($type);

try {
    $db = new PDO('sqlite:../database/LTW.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $allowedTables = ['Category', 'Size', 'Condition']; // Define allowed table names
    if (!in_array($type, $allowedTables)) {
        throw new Exception('Invalid table name.');
    }

    $stmt =$db->prepare("DELETE FROM $type WHERE id =:id"); 
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    http_response_code(500); 
    exit('Error: ' . $e->getMessage());
}
