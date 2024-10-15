<?php
        session_start();
        $db = new PDO('sqlite:../database/LTW.db');
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST["description"];
        $model = $_POST["Model"];
        $brand = $_POST['Brand'];
        $conditionn = $_POST['Condition'];
        $sizee = $_POST["Size"];
        $category = $_POST["Category"];
        
        
        // Verificacao!
        if(!isset($_SESSION['User'])){
            $_SESSION['error'] = "No User logged in!";
            header("Location: ../products/new_product.php");
            exit;
        }
        if(is_numeric($price)){
            $price_num = intval($price);
        }
        else{
            $_SESSION['error'] = "Not an number inserted!";
            header("Location: ../products/new_product.php");
            exit;
        }
        if(strlen($title)>=60){
            $_SESSION['error'] = "Title too long!";
            header("Location: ../products/new_product.php");
            exit;
        }
        if(strlen($model)>=60){
            $_SESSION['error'] = "Model type too long!";
            header("Location: ../products/new_product.php");
            exit;
        }
        if(strlen($brand)>=60){
            $_SESSION['error'] = "Brand type too long!";
            header("Location: ../products/new_product.php");
            exit;
        }

        // Treat files
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $_SESSION['error'] = "File is not an image.";
            header("Location: ../products/new_product.php");
            exit;
        }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION['error'] = "Sorry, file already exists.";
            header("Location: ../products/new_product.php");
            exit;
        }
        
        // Check file size
        if ($_FILES["picture"]["size"] > 500000) {
            $_SESSION['error'] = "File too big.";
            header("Location: ../products/new_product.php");
            exit;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $_SESSION['error'] = "File too big.";
            header("Location: ../products/new_product.php");
            exit;
        }
        if(!move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)){
            $_SESSION['error'] = "Error uploading your file.";
            header("Location: ../products/new_product.php");
            exit;
        }

        //Conseguir Size, Condition e Category
        $cat = $db->prepare('SELECT Category.*
        FROM Category
        WHERE Category.name=:product');
        $cat->execute([':product'=>$category]);
        $categoria = $cat->fetch();
        if(empty($categoria)){
            $_SESSION['error'] = "Category went wrong!";
            header("Location: ../products/new_product.php");
            exit;
        }

        $size = $db->prepare('SELECT Size.*
        FROM Size
        WHERE Size.name=:product');
        $size->execute([':product'=>$sizee]);
        $tamanho = $size->fetch();
        if(empty($tamanho)){
            $_SESSION['error'] = "Size went wrong!";
            header("Location: ../products/new_product.php");
            exit;
        }

        $condition = $db->prepare('SELECT Condition.*
        FROM Condition
        WHERE Condition.name=:product');
        $condition->execute([':product'=>$conditionn]);
        $condicao = $condition->fetch();
        if(empty($condicao)){
            $_SESSION['error'] = "Condition went wrong!";
            header("Location: ../products/new_product.php");
            exit;
        }

        //Get User
        $user = $db->prepare('SELECT Users.*
        FROM Users
        WHERE Users.username=:product');
        $user->execute([':product'=>$_SESSION['User']]);
        $utilizador = $user->fetch();
        if(empty($utilizador)){
            $_SESSION['error'] = "User went wrong!";
            header("Location: ../products/new_product.php");
            exit;
        }

        $stmt = $db->prepare("INSERT INTO Product(title, description, price, image, creator_id, category_id, size_id, condition_id,brand,model) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($title,$description,$price,$target_file,$utilizador['id'],$categoria['id'],$tamanho['id'],$condicao['id'],$brand,$model));
        header("Location: ../index.php");
        exit;
?>