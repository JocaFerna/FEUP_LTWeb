<?php
        session_start();
        $db = new PDO('sqlite:../database/LTW.db');
        $username = $_POST['uname'];
        $password = $_POST['psw'];
        $testquery = $db->prepare("SELECT password FROM Users WHERE Username=:userrr");
        $testquery->execute([':userrr'=>$username]);
        $passe = $testquery->fetch(PDO::FETCH_ASSOC);
        if(empty($passe)){
            $_SESSION['error'] = "Username does not exist, please try to create a new account!";
            header("Location: ../login.php");
            exit;
        }
        else if($passe['password'] != sha1($password)){
            $_SESSION['error'] = "Incorrect Password!";
            header("Location: ../login.php");
            exit;
        }
        else{
            $_SESSION['User'] = $username;
            header("Location: ../index.php");
            exit;
        }
?>