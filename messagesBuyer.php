<!DOCTYPE html>
<html lang="en">
<head>
<title>S.O.S - Contact Seller</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/message.css">
    <script src="javascript/messages.js">
    </script>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['User'])==false){
            header("Location: /login.php");
            exit;
        };
        $loggedInUser = $_SESSION['User']; 
        $db = new PDO('sqlite:./database/LTW.db');
        $query1 = $db->prepare("SELECT id FROM Users WHERE username = :loggedInUser");
        $query1->execute([':loggedInUser' => $loggedInUser]);
        $userr = $query1->fetch();
        //var_dump($userr['id']);
        $loggedInUserId = $userr['id'];
        $query = $db->prepare("SELECT product.title AS title, Chat.id AS chat_id
                    FROM Chat JOIN Product ON Chat.product_id = Product.id
                    WHERE Chat.user_id = :loggedInUserId");
        $query->execute([':loggedInUserId' => $loggedInUserId]);
        $products = $query->fetchAll();
        //var_dump($products);
        foreach($products as $product){
            //var_dump($product['chat_id']);
            $querymessages = $db->prepare("SELECT Comment.content AS content , Comment.user_id AS sender, Comment.chat_id AS chat_id
            FROM Comment 
            JOIN Chat ON Chat.id = Comment.chat_id
            JOIN Product ON Chat.product_id = Product.id
            WHERE Chat.user_id = :loggedInUserId AND Product.title = :productTitle");
            $querymessages->execute([':loggedInUserId' => $loggedInUserId, ':productTitle' => $product['title']]);
            $messages = $querymessages->fetchAll(); 
            $allmessages[$product['title']] = $messages;
        }
        echo '<script>let messages = ' . json_encode($allmessages) . '; console.log(messages); let loggedInUserID = ' . json_encode($loggedInUserId) . '; console.log(loggedInUserID);</script>';
    ?>
    <div class="parent">
        <div class="messages-container">
            <div class="row">
                <div class="col-md-4">
                <div class="back-button">
                    <a href="index.php"></a>
                </div>
                    <h1>Your Chats</h1>
                    <div class="conversation-list">
                        <section class="blinds">
                            <dt>Products</dt>
                            <div class="blinds">
                                <?php
                                    if (count($products) == 0) {
                                        echo "<dd>No results found :(.</dd>";
                                    } else {
                                        foreach ($products as $product) {
                                            echo "<dd onclick='currentChatId = {$product['chat_id']}; console.log(currentChatId); addMessages(\"{$product['title']}\");'>{$product['title']}</dd>";
                                        }
                                    }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="selected-conversation">
                        <h1>Your Messages</h1>
                        <!-- Message display area -->
                        <div class="message-container">
                            <!-- Messages will be dynamically added here -->
                        </div>
                        <!-- Message input area -->
                        <div class="message-input">
                            <form method="POST" action="#">
                                <input type="text" name="content" placeholder="Type a message..." class="message-textbox">
                                <button type="submit" class="send-button">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
