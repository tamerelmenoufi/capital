<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $tempo = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s")-1, date("m"), date("d"), date("Y")));

    $query = "SELECT a.*, b.codigo as cod_cliente, b.nome FROM wapp_chat a left join clientes b on REPLACE(REPLACE(REPLACE(REPLACE(b.phoneNumber, '(', ''), ')', ''), '-', ''), ' ', '') = a.de where a.data >= '{$tempo}'";
    $result = mysqli_query($con, $query);
    $retorno = [];
    while($d = mysqli_fetch_object($result)){
        $nome = explode(" ", trim($d->nome))[0];
        $retorno[] = [ 
                        "type" => "chat",
                        "text" => $d->mensagem,
                        "de" => $d->de,
                        "nome" => $nome,
                        "para" => $d->para,
                        "codigo" => $d->cod_cliente,
                        "data" => dataBr($d->data)];
    }

    echo json_encode($retorno);