let currenrChatId;
        console.log(currenrChatId);
        document.addEventListener("DOMContentLoaded", function() {
            // Handle conversation selection
            let conversationLinks = document.querySelectorAll('.conversation-list dd');
            conversationLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    let conversationName = this.textContent;
                    document.querySelector('.selected-conversation h1').textContent = conversationName;
                    clearMessageContainer();
                    let placeholderMessages = getMessages(conversationName);
                    addMessages(placeholderMessages);
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

                    let xhreq = new XMLHttpRequest();
                    xhreq.open('POST', '/php/save_messages.php', true);
                    xhreq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhreq.send('message=' + encodeURIComponent(message) + '&chat_id=' + encodeURIComponent(currentChatId) + '&user_id=' + encodeURIComponent(loggedInUserID));
                    if (xhreq.status == 200) {
                        location.reload();
                    }
                }    
            });

            function clearMessageContainer() {
                let messageContainer = document.querySelector('.message-container');
                messageContainer.innerHTML = '';
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
        function getMessages(productTitle) {
            console.log(productTitle);
            return messages[productTitle] || [];
        }
        function addMessages(messages) {
            //console.log(messages);
            let messageContainer = document.querySelector('.message-container');
            //console.log(messageContainer);
            messages.forEach(function(message) {
            let speechBubble = document.createElement('div');
            //console.log(message.sender);
            if (message.sender == loggedInUserID) {
                speechBubble.classList.add('speech-bubble', 'sent-message');
            } else {
                speechBubble.classList.add('speech-bubble', 'received-message');
            }
            //console.log(message.content);
            speechBubble.textContent = message.content;
            messageContainer.appendChild(speechBubble);
            });
        }