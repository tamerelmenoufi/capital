<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
</head>
<body>
    <h1>WebSocket Client</h1>
    <input type="text" id="messageInput" placeholder="Digite sua mensagem">
    <button onclick="sendMessage()">Enviar</button>
    <div id="messages"></div>
    
    <script>
        const socket = new WebSocket('wss://capital.mohatron.com:3000');
        const messagesDiv = document.getElementById('messages');

        socket.onopen = function () {
            console.log('Conexão estabelecida com sucesso.');
        };

        socket.onmessage = function (event) {
            const message = event.data;
            console.log(event)
            messagesDiv.innerHTML += `<div>${message}</div>`;
        };

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;
            console.log(message);
            socket.send(message);
            console.log('mensagem enviada')
            messageInput.value = '';
        }
    </script>
</body>
</html>
