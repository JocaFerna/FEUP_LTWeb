<?php
    session_start();
    $content = trim(file_get_contents("php://input"));
    $_arr = json_decode($content, true);
    $username = $_arr["user_id"];
    $product_id = $_arr["product_id"];
    $db = new PDO('sqlite:../database/LTW.db');

    $queue = $db->prepare("SELECT Users.id as id
    FROM Users
    WHERE Users.username=:userr");
    $queue->execute(['userr'=>$username]);
    $id_row = $queue->fetch();

    $id = $id_row['id'];

    //Verify if already exists
    $queue = $db->prepare("SELECT *
    FROM Chat
    WHERE Chat.product_id=:product AND Chat.user_id=:userr");
    $queue->execute(['userr'=>$id,'product'=>$product_id]);
    $possible_wishlist = $queue->fetchAll();

    if(sizeof($possible_wishlist)>=1){
        $data = array( "message"=>"Chat created","location" => "messagesBuyer.php");
        echo json_encode($data);
        exit;
        //exit(header("Location: messagesBuyer.php"));
    }
    else{
        //If it doens't exist, add it!
        $insert = $db->prepare("INSERT INTO Chat(user_id, product_id) VALUES (:userr, :product)");
        $insert->execute(['userr'=>$id,'product'=>$product_id]);
        $data = array( "message"=>"Chat created","location" => "messagesBuyer.php");
        echo json_encode($data);
        exit;
        //exit(header("Location: messagesBuyer.php"));
    }
?>