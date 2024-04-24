<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente JavaScript</title>
</head>
<body>
    <h1>Cliente JavaScript</h1>
    <textarea id="message" rows="4" cols="50"></textarea><br>
    <button onclick="sendMessage()">Enviar</button>
    <div id="response"></div>

    <script>
        function sendMessage() {
            var message = document.getElementById("message").value;

            // Criando uma requisição AJAX para enviar a mensagem para o servidor
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "ws://206.81.10.165:9501", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    document.getElementById("response").innerText = xhr.responseText;
                }
            };
            xhr.send(message);
        }
    </script>
</body>
</html>
