<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $mensagem = "A mensagem foi enviada por {$_POST['idChat']} com o conteúdo {$_POST['text']}";

    $retorno = [ "type" => "chat", "text" => $mensagem];
    
    echo json_encode($retorno);