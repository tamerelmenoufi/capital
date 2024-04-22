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
        /*const socket = new WebSocket('ws://capital.mohatron.com:3000');
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
        }*/

        let socket = new WebSocket("wss://javascript.info/article/websocket/demo/hello");

        socket.onopen = function(e) {
        alert("[open] Connection established");
        alert("Sending to server");
        socket.send("My name is John");
        };

        socket.onmessage = function(event) {
        alert(`[message] Data received from server: ${event.data}`);
        };

        socket.onclose = function(event) {
        if (event.wasClean) {
            alert(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
        } else {
            // e.g. server process killed or network down
            // event.code is usually 1006 in this case
            alert('[close] Connection died');
        }
        };

        socket.onerror = function(error) {
        alert(`[error]`);
        };
    </script>
</body>
</html>
