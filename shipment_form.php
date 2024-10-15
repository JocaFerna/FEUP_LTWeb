<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/drcustoms.css">
    <link rel="stylesheet" type="text/css" href="/css/shipment.css">
    <title>S. O. S.</title>

</head>
<body>
    <?php
    session_start();
    $json_result = urldecode($_GET['data']);
    if(isset($_SESSION['User'])==false){
        header("Location: /index.php");
        exit;
    };
    $db = new PDO('sqlite:./database/LTW.db');


    // Decode the JSON data back into an array
    $articles = json_decode($json_result, true);
    ?>
    <h2>Your order was sucessfully created!</h2>
    <h3><b>Address: </b><?php echo $articles['address'];?></h3>
    <h3><b>Payment Type: </b><?php echo $articles['MethodPayment'];?></h3>
    <h3><b>Shipment: </b><?php echo $articles['shipment'];?></h3>
    <h3><b>Buyer: </b><?php echo $articles['user'];?></h3>
    <h3><b>Date: </b><?php echo $articles['date'];?></h3>
    <h3><b>Products: </b>
    <?php
    $string = "";
    $price = 0;
    foreach($articles['products'] as $product){
        $get = $db->prepare("SELECT * FROM Product WHERE id=:product");
        $get->execute(['product'=>$product]);
        $producto = $get->fetch();
        $string = $string.$producto['title'].", ";
        $price = $price + floatval($producto['price']);
    }
    echo substr($string, 0, -2);
    ?></h3>
    <h3><b>Price: </b><?php echo $price;?>$</h3>
    <h3 class="info">Feel Free to Print this form!</h3>
</body>
</html>