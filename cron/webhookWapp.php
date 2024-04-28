<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
        $_POST = file_get_contents('php://input');
        
        // $_POST = json_decode(file_get_contents('php://input'), true);

        if($_POST['event'] == 'message' and $_POST['chat_type'] == 'user'){

            $query = "insert into wapp_chat set 
                                                de = '".substr($_POST['contact_phone_number'],2,strlen($_POST['contact_phone_number']))."',
                                                para = '{$_POST['phone_number']}',
                                                tipo = '{$_POST['message_type']}',
                                                mensagem = '{$_POST['message_body']}',
                                                data = NOW()";
            mysqli_query($con, $query);

        }

    file_put_contents("wgw.txt", print_r($_POST, true));