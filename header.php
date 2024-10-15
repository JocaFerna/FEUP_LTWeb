<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <form action="<?php  echo "/php/search_request.php" ?>" method="get">
        <nav class="top-bar">
            <a href="/index.php"><img id="logo" src="" alt="S.O.S"></a>
            <?php
            session_start(); // Start the session at the beginning

            $isAdmin = false; // Default to non-admin
            if (isset($_SESSION['User'])) {
                $username = $_SESSION['User'];
            
                // Query the database to get the user's admin status
                try {
                    $db = new PDO('sqlite:./database/LTW.db');
                    $stmt = $db->prepare('SELECT isAdmin FROM Users WHERE username = :username');
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Check if the user is an admin
                    if ($result && $result['isAdmin']) {
                        $isAdmin = true;
                    }
                } catch (PDOException $e) {
                    // Handle potential PDO exceptions
                    error_log('PDOException: ' . $e->getMessage());
                }
            }
            if ($isAdmin){
            ?>
            <a id="admin-link" href="./admin_page.php">Admin</a>
            <?php } ?>
            <div class="search">
                <input type="text" name="text" id="search-bar" placeholder="Search...">
                <button type="submit" class="button"><b>Search</b></button>
            </div>
            <div class="dropdown">
                <?php
                if(!isset($_SESSION['User'])){
                    ?>
                    <a href = "/login.php">Login</a>
                    <?php
                }
                else{
                    ?>
                        <button type="button" class="dropbtn"><i class="fa fa-user" aria-hidden="true"></i>
                        </button>
                            <div class="dropdown-content">
                            <a href="/user/user_products.php">My Products</a>
                            <a href="/user/checkout.php">Checkout</a>
                            <a href="/profile.php">Profile</a>
                            <a href="/products/new_product.php">Add Product</a>
                            <a href="/php/logout.php">Logout</a>
                            </div>
                    <?php
                }
                ?>
                
                
            </div> 
        </nav>
      
      