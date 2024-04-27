<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $tempo = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s")-1, date("m"), date("d"), date("Y")));

    $query = "SELECT * FROM `wapp_chat` where data >= '{$tempo}'";
    $result = mysqli_query($con, $query);
    $retorno = [];
    while($d = mysqli_fetch_object($result)){
        $retorno[] = [ "type" => "chat", "text" => $d->mensagem, "de" => $d->de, "para" => $d->para, "data" => dataBr($d->data)];
    }

    echo json_encode($retorno);