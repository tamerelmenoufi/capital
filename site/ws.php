<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
</head>
<body>
    <input id="messageInput" type="text">
    <button onclick="sendMessage()">Send Message</button>
    <ul id="messages"></ul>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.0/socket.io.js"></script>
    <script>
        const socket = io('https://capitalsolucoesam.com.br:3000');

        socket.on('chat message', function(msg){
            const messages = document.getElementById('messages');
            const li = document.createElement('li');
            li.textContent = msg;
            messages.appendChild(li);
        });

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value;
            socket.emit('chat message', message);
            input.value = '';
        }
    </script>
</body>
</html>
