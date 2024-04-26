<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $query = "SELECT * FROM `wapp_chat` where data <= NOW() order by rand() limit 1";
    $result = mysqli_query($con, $query);
    $retorno = [];
    while($d = mysqli_fetch_object($result)){
        $retorno[] = [ "type" => "chat", "text" => $d->mensagem, "de" => $d->de, "para" => $d->para ];
    }

    // $mensagem = "A mensagem foi enviada por {$_POST['idChat']} com o conteúdo {$_POST['text']}";

    // $retorno = [ "type" => "chat", "text" => $mensagem];
    
    echo json_encode($retorno);