<?php
    session_start();
    $content = trim(file_get_contents("php://input"));

    //this content should be a json already
    //{"first_name":"first name","last_name":"last name"}

    //if want to access values
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
    FROM Wishlist
    WHERE Wishlist.product_id=:product AND Wishlist.user_id=:userr");
    $queue->execute(['userr'=>$id,'product'=>$product_id]);
    $possible_wishlist = $queue->fetchAll();

    if(sizeof($possible_wishlist)>=1){
        $data = array( "message"=>"Already in wish list!");
        echo json_encode($data);
        exit;
    }
    else{
        //If it doens't exist, add it!
        $insert = $db->prepare("INSERT INTO WishList(user_id, product_id) VALUES (:userr, :product)");
        $insert->execute(['userr'=>$id,'product'=>$product_id]);
        $data = array( "message"=>"Item added to wish list");
        echo json_encode($data);
        exit;
    }
?>