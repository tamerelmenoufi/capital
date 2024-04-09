<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function sendMultiple($msg){
        
        $content = http_build_query($msg);
              
        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => $content,
            )
        ));
                
        echo $result = file_get_contents('http://sms.mohatron.com/pontal.php', null, $context);
        $r = json_decode($result);
        
    
    }



    $query = "select a.dados as log, a.cliente as cod_cliente, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '2024-04-09%' and a.dados->>'$.statusCode' = '200' group by b.cpf order by b.nome asc";
    $result = sisLog( $query);
    while($d = mysqli_fetch_object($result)){

    $log = json_decode($d->log);

    $nome = explode(" ",trim($d->nome))[0];
    $valor = number_format($log->data->simulationData->totalReleasedAmount,2,',','.');

    $mensagem = "Capital Soluções Informa: {$nome}, seu FGTS atualizou, já pode antecipar R\${$valor}. Acesse capitalsolucoesam.com.br é fácil, Rápido e Seguro.";
    $caracteres = strlen($mensagem); 
    // echo $mensagem."<br>";
    $msg_list[] = [
        'to' =>  str_replace(['(',')',' ','-'],false,$d->phoneNumber),
        'message' => $mensagem,
        'reference' => "lote-".date("YmdHis"),
        // 'caracteres' => $caracteres,
        ];
    }

    $novos = [
        ['nome' => 'Eliandro', 'telefone' => '92982010593', 'valor' => '98.765,43'],
        ['nome' => 'José', 'telefone' => '92981183804', 'valor' => '98.765,43'],
        ['nome' => 'Tamer', 'telefone' => '92991886570', 'valor' => '98.765,43']
    ];

    foreach($novos as $i => $d){
    $mensagem = "Capital Soluções Informa: {$d['nome']}, seu FGTS atualizou, já pode antecipar R\${$d['valor']}. Acesse capitalsolucoesam.com.br é fácil, Rápido e Seguro.";
    
    $msg_list[] = [
        'to' =>  $d['telefone'],
        'message' => $mensagem,
        'reference' => "lote-".date("YmdHis"),
        // 'caracteres' => $caracteres,
        ];
    }
    
    // print_r($msg_list);

    // $response = sendMultiple($msg_list);

    // mysqli_query($con, "update clientes set simulacao_10 = '1' where codigo = '{$d->codigo}'");





?>
