<?php
        session_start();
        $db = new PDO('sqlite:../database/LTW.db');
        $address = $_POST['address'];
        $payment = $_POST['MethodPayment'];
        $shipment = $_POST["Shipment"];
        
        
        // Verificacao!
        if(!isset($_SESSION['User'])){
            $_SESSION['error'] = "No User logged in!";
            header("Location: /index.php");
            exit;
        }
        
        if(strlen($address)>=60){
            $_SESSION['error'] = "Address too long!";
            header("Location: /checkout.php");
            exit;
        }
        $username = $_SESSION['User'];
        $queue = $db->prepare("SELECT Users.id as id
        FROM Users
        WHERE Users.username=:userr");
        $queue->execute(['userr'=>$username]);
        $id_row = $queue->fetch();
        $id = $id_row['id'];
        $stmt = $db->prepare('SELECT ShoppingCart.id
        FROM Product LEFT JOIN ShoppingCart ON ShoppingCart.product_id=Product.id
        WHERE ShoppingCart.user_id = :userr');
        $stmt->execute(['userr'=>$id]);
        $articles = $stmt->fetchAll();

        $to_send = array();
        $to_send['address'] = $address;
        $to_send['MethodPayment'] = $payment;
        $to_send['shipment'] = $shipment;
        $to_send['user'] = $username;
        $to_send['date'] = date("Y/m/d");

        $products = array();
        foreach($articles as $article){
            $get = $db->prepare("SELECT ShoppingCart.product_id FROM ShoppingCart WHERE id=:product");
            $get->execute(['product'=>$article['id']]);
            $product = $get->fetch();
            array_push($products,$product['product_id']);
            $delete = $db->prepare("DELETE FROM ShoppingCart WHERE id=:product");
            $delete->execute(['product'=>$article['id']]);
            $update = $db->prepare("UPDATE Product SET isBought=TRUE WHERE id = :product");
            $update->execute(['product'=>$product['product_id']]);
            $insert = $db->prepare("INSERT INTO Shipment(address, type, methodPayment, product_id, buyer_id) VALUES (:addresss, :typee, :methodpayment,:product,:userr)");
            $insert->execute(['userr'=>$id,'product'=>$product['product_id'],'addresss'=>$address,'typee'=>$shipment,'methodpayment'=>$payment]);

        }
        $to_send['products'] = $products;
        $send = json_encode($to_send);
        header("Location: ../shipment_form.php?data=".urlencode($send));
        exit;
?>