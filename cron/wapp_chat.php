<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $tempo = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s")-1, date("m"), date("d"), date("Y")));

    $query = "SELECT a.*, b.codigo as cod_cliente, b.nome FROM wapp_chat a left join clientes b on REPLACE(REPLACE(REPLACE(REPLACE(b.phoneNumber, '(', ''), ')', ''), '-', ''), ' ', '') = a.de where a.data >= '{$tempo}'";
    $result = mysqli_query($con, $query);
    $retorno = [];
    $update = [];
    $listaFiles = ['audio', 'image', 'document', 'file'];
    while($d = mysqli_fetch_object($result)){
        $nome = explode(" ", trim($d->nome))[0];
        $retorno[] = [ 
                        "type" => "chat",
                        "text" => (((in_array($d->tipo,$listaFiles))?$localPainel."/src/volume/wappChat/":false).$d->mensagem),
                        "de" => $d->de,
                        "nome" => $nome,
                        "para" => $d->para,
                        "tipo" => $d->tipo,
                        "documento" => $d->documento,
                        "codigo_cliente" => $d->cod_cliente,
                        "codigo_mensagem" => $d->codigo,
                        "data" => dataBr($d->data)];
        // if($d->cod_cliente) $update[] = $d->cod_cliente;
    }

    if($update){
        // mysqli_query($con, "update clientes set ultimo_chat = NOW() where codigo in (".implode(", ",$update).")");
    }

    echo json_encode($retorno);