<?php
        session_start();
        $db = new PDO('sqlite:../database/LTW.db');
        $name = $_POST['name'];
        $username = $_POST['uname'];
        $email = $_POST["email"];
        $password = $_POST["psw"];
        $cpassword = $_POST["cpsw"];
        if($password!=$cpassword){
            $_SESSION['error'] = "Password and Confirm Password doesn't match!";
            header("Location: ../edit_profile.php");
            exit;
        }
        else if(strlen($password)<=7){
            $_SESSION['error'] = "Password too short! Must be more or equal to 8 digits!";
            header("Location: ../edit_profile.php");
            exit;
        }
        $userid = $db->prepare("SELECT * FROM Users WHERE username=:userrr");
        $userid->execute([':userrr'=>$_SESSION['User']]);
        $user = $userid->fetch(PDO::FETCH_ASSOC);
        if($user['username']!=$username){
            $testquery = $db->prepare("SELECT * FROM Users WHERE username=:userrr");
            $testquery->execute([':userrr'=>$username]);
            $passe = $testquery->fetch(PDO::FETCH_ASSOC);
            if(!empty($passe)){
                $_SESSION['error'] = "User already taken, please try another!";
                header("Location: ../register.php");
                exit;
            }
        }
        $newuser = $db->prepare("UPDATE Users SET username=:userrr , password=:pass , name=:namee , email=:emaile WHERE id=:ide");
        $newuser->execute([':userrr'=>$username,':pass'=>sha1($password),':namee'=>$name,':emaile'=>$email,':ide'=>$user['id']]);
        $updatedUser = $newuser->fetch(PDO::FETCH_ASSOC);
        $_SESSION['User'] = $username;
        $_SESSION['error'] = "User's profile updated sucessfully!";
        header("Location: ../profile.php");
        exit;
        
?>