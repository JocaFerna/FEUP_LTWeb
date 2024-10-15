<!DOCTYPE html>
<html lang="en">
<head>
    <title>S.O.S - messages</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/message.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle conversation selection
            let conversationLinks = document.querySelectorAll('.conversation-list dd');
            conversationLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    let conversationName = this.textContent;
                    document.querySelector('.selected-conversation h1').textContent = conversationName;
                    clearMessageContainer();
                    let placeholderMessages = getPlaceholderMessages(conversationName);
                    addPlaceholderMessages(placeholderMessages);
                });
            });

            // Display sent message in speech bubble
            let form = document.querySelector('.message-input form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                let messageInput = this.querySelector('.message-textbox');
                let message = messageInput.value.trim();
                if (message !== '') {
                    let messageContainer = document.querySelector('.message-container');
                    let speechBubble = document.createElement('div');
                    speechBubble.classList.add('speech-bubble', 'sent-message');
                    speechBubble.textContent = message;
                    messageContainer.appendChild(speechBubble);
                    messageInput.value = ''; // Clear the input field
                }
            });

            function clearMessageContainer() {
                let messageContainer = document.querySelector('.message-container');
                messageContainer.innerHTML = '';
            }

            function getPlaceholderMessages(conversationName) {
                let placeholderMessages = {
                    "Marco": ["Hi, I was interested in this product of yours", "For how much are you willing to for it?"],
                    "Gina": ["Hello, was looking to buy this for my son he's a collector", "Can you assure me its official "],
                    "Conde Igor":["Treat Yourself."],
                };
                return placeholderMessages[conversationName] || [];
            }
            function addPlaceholderMessages(messages) {
                let messageContainer = document.querySelector('.message-container');
                messages.forEach(function(message) {
                    let speechBubble = document.createElement('div');
                    speechBubble.classList.add('speech-bubble', 'received-message');
                    speechBubble.textContent = message;
                    messageContainer.appendChild(speechBubble);
                });
            }
        });
        // Drop Down menu for conversations
        document.addEventListener("DOMContentLoaded", function() {
            let dts = document.querySelectorAll('dt');
            dts.forEach(function(dt) {
                dt.addEventListener('click', function() {
                    this.classList.toggle('open');
                    let section = this.parentElement;
                    while (section && !section.classList.contains('blinds')) {
                        section = section.parentElement;
                    }
                    if (section) {
                        section.classList.toggle('expanded');
                    }
                });
            });
        });
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
        //echo $loggedInUser;
        //echo $userr['id'];
        $loggedInUserId = $userr['id'];
        $query = $db->prepare("SELECT product.title AS title
                    FROM Chat JOIN Product ON Chat.product_id = Product.id
                    WHERE Chat.user_id = :loggedInUserId");
        $query->execute([':loggedInUserId' => $loggedInUserId]);
        $products = $query->fetchAll();
        $productId = $products['id'];
        $query2 = $db->prepare("SELECT Users.username AS user_name
                    FROM Chat 
                    JOIN Users ON Chat.user_id = Users.id
                    JOIN Product ON Chat.product_id = Product.id
                    WHERE Product.id = :productId");
        $query2 ->execute([':productId' => $productId]);
        $users = $query2->fetchAll();

    ?>
    <div class="parent">
        <div class="messages-container">
            <div class="row">
                <div class="col-md-4">
                    <h1>Your Products</h1>
                    <div class="conversation-list">
                        <section class="blinds">
                            <dt>Products</dt>
                            <div class="blinds">
                                <?php
                                    $products = [
                                        "Product 1" => ["Marco", "Gina", "Conde Igor"],
                                        "Product 2" => [ "Sguerry", "Berto", "Gaby"],
                                        "Product 3" => ["Duque Cirilo II", "Ardélia"]
                                    ];
                                    foreach ($products as $product => $customers) {
                                        echo "<dt>$product</dt>";
                                        echo "<div class='blinds'>";
                                        if (is_array($customers)) {
                                            foreach ($customers as $customer) {
                                                echo "<dd>$customer</dd>";
                                            }
                                        }
                                        echo "</div>";
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
