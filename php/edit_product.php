<?php
if (!isset($_POST['id'])||!isset($_POST['title'])||!isset($_POST['price'])||!isset($_POST['status'])||!isset($_POST['model'])||!isset($_POST['brand'])) {
    http_response_code(400); 
    exit("Error: Id parameter is missing.");
}

if (!file_exists('../database/LTW.db')) {
    error_log('SQLite database file does not exist.');
} elseif (!is_readable('../database/LTW.db')) {
    error_log('SQLite database file is not readable.');
}

$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
$title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_FLOAT);
$status = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
$model = filter_var($_POST['model'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$brand = filter_var($_POST['brand'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);


try {
    $db = new PDO('sqlite:../database/LTW.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare('UPDATE Product SET title = :title, price = :price, isBought = :status, model = :model, brand = :brand  WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':price',$price);
    $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
    $stmt->bindParam(':model', $model, PDO::PARAM_STR);
    $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    $stmt->execute();

   
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    http_response_code(500); 
    exit('Error: ' . $e->getMessage());
}