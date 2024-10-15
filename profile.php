<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S. O. S.</title>
    <link rel="stylesheet" type="text/css" href="css/drcustoms.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <?php
        session_start();
        $db = new PDO('sqlite:./database/LTW.db');
        $username = $_SESSION['User'];
        $testquery = $db->prepare("SELECT * FROM Users WHERE Username=:userrr");
        $testquery->execute([':userrr'=>$username]);
        $user = $testquery->fetch(PDO::FETCH_ASSOC);
    ?>
  <div class="profile-box">

    <h1><b>Profile</b></h1>

    <div class="profile-group">
        <label for="name"><b>Name: </b></label>
        <span class="profile">
            <?php
                echo $user['name'];
            ?>
        </span>
    </div>

    <div class="profile-group">
        <label for="email"><b>E-Mail: </b></label>
        <span class="profile">
            <?php
                echo $user['email'];
            ?>
        </span>
    </div>

    <div class="profile-group">
        <label for="uname"><b>Username: </b></label>
        <span class="profile">
            <?php
                echo $user['username'];
            ?>
        </span>
    </div>
    <div class="buttonslogin">
        <a href="edit_profile.php" class="buttonForA"><b>Edit Profile</b></a>
    </div>
    <span class="success" id="msg">
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']); // Clear the error message from the session
        }
        ?>
    </span>
        </div>
    </body>