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

    //Verify if item is already bought!
    $queue = $db->prepare("SELECT *
    FROM Product
    WHERE Product.id=:product");
    $queue->execute(['product'=>$product_id]);
    $produto = $queue->fetch();

    if($produto['isBought']=="TRUE"){
        $data = array("message"=>"Product already Bought!");
        echo json_encode($data);
        exit;
    }
    //Verify if already exists
    $queue = $db->prepare("SELECT *
    FROM ShoppingCart
    WHERE ShoppingCart.product_id=:product AND ShoppingCart.user_id=:userr");
    $queue->execute(['userr'=>$id,'product'=>$product_id]);
    $possible_wishlist = $queue->fetchAll();

    if(sizeof($possible_wishlist)>=1){
        $data = array( "message"=>"Already in cart!");
        echo json_encode($data);
        exit;
    }
    else{
        //If it doens't exist, add it!
        $insert = $db->prepare("INSERT INTO ShoppingCart(user_id, product_id) VALUES (:userr, :product)");
        $insert->execute(['userr'=>$id,'product'=>$product_id]);
        $data = array( "message"=>"Item added to shopping cart");
        echo json_encode($data);
        exit;
    }
?>