<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $tempo = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s")-2, date("m"), date("d"), date("Y")));

    $query = "SELECT * FROM `wapp_chat` where data >= '{$tempo}'";
    $result = mysqli_query($con, $query);
    $retorno = [[ "type" => "chat", "text" => $query, "de" => $d->de, "para" => $d->para ]];
    while($d = mysqli_fetch_object($result)){
        $retorno[] = [ "type" => "chat", "text" => $d->mensagem, "de" => $d->de, "para" => $d->para ];
    }

    // $mensagem = "A mensagem foi enviada por {$_POST['idChat']} com o conteúdo {$_POST['text']}";

    // $retorno = [ "type" => "chat", "text" => $mensagem];
    
    echo json_encode($retorno);