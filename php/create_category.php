<?php
if (!isset($_POST['categoryName'])|| !isset($_POST['type'])) {
    http_response_code(400); 
    exit("Error: Parameter is missing.");
}
if (!file_exists('../database/LTW.db')) {
    error_log('SQLite database file does not exist.');
} elseif (!is_readable('../database/LTW.db')) {
    error_log('SQLite database file is not readable.');
}

$name = filter_var($_POST['categoryName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$type = filter_var($_POST['type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try {
    $db = new PDO('sqlite:../database/LTW.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $allowedTables = ['Category', 'Size', 'Condition']; // Define allowed table names
    if (!in_array($type, $allowedTables)) {
        throw new Exception('Invalid table name.');
    }
    $stmt = $db->prepare("INSERT INTO $type (name) VALUES (:name)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();

    $newCategoryId = $db->lastInsertId();
    echo $newCategoryId . '.' . $name;

} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    http_response_code(500); 
    exit('Error: ' . $e->getMessage());
}
