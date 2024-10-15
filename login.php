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
<form action="php/login.php" method="post">
  <div class="login">

    <h1><b>Login</b></h1>

    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" class="inputbox" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" class="inputbox"  required>

    <label for="remember" class="remember"><input type="checkbox" checked="checked" name="remember"> Remember me</label>
    <div class="buttonslogin">
        <button type="submit" class="button"><b>Login</b></button>
        <a href="register.php" class="buttonForA"><b>Register</b></a>
    </div>
    <span class="error" id="msg">
    <?php
    session_start();
      if (isset($_SESSION['error'])) {
          echo $_SESSION['error'];
          unset($_SESSION['error']); // Clear the error message from the session
      }
    ?>
    </span>
  </div>
</form> 


</body>
</html>