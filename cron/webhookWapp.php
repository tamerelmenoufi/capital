<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $_POST = file_get_contents('php://input');
        
        // $_POST = json_decode(file_get_contents('php://input'), true);

        if($_POST['event'] == 'message' and $_POST['chat_type'] == 'user'){

            if($_POST['message_type'] == 'audio'){
                $mensagem = "data:audio/ogg; codecs=opus;base64,".str_replace(" ","+",$_POST['message_body']);
                // file_put_contents('audio'.$_POST['message_body_extension'], base64_decode($_POST['message_body']));
            }else{
                $mensagem = $_POST['message_body'];
            }

            $query = "insert into wapp_chat set 
                                                de = '".substr($_POST['contact_phone_number'],2,strlen($_POST['contact_phone_number']))."',
                                                para = '{$_POST['phone_number']}',
                                                tipo = '{$_POST['message_type']}',
                                                mensagem = '{$mensagem}',
                                                data = NOW()";
            mysqli_query($con, $query);

        }

    file_put_contents("wgw.txt", print_r($_POST, true));