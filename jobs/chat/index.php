<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Our Business</title>
</head>
<body>

<div id="chat-container">
    <div id="chat-messages"></div>
    <div id="user-input">
        <input type="text" id="user-message" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var chatLog = "";

    $("#user-message").keyup(function(event) {
        if (event.keyCode === 13) {
            sendMessage();
        }
    });

    function sendMessage() {
    var userMessage = $('#user-message').val();
    
    // Display user message
    displayMessage('You', userMessage);
    chatLog += userMessage + "\n";

    // Send user message to PHP script for processing
    $.ajax({
        type: 'POST',
        url: 'process_message.php',
        data: { message: chatLog },
        success: function(response) {
            // Display OpenAI's response
            displayMessage('Business', response);
            chatLog += response + "\n";
        }
    });

    // Clear input field
    $('#user-message').val('');
    }

    function displayMessage(sender, message) {
        $('#chat-messages').append('<p><strong>' + sender + ':</strong> ' + message + '</p>');
    }
</script>

</body>
</html>
