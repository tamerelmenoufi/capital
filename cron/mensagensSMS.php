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



    $query = "select * from clientes where codigo = '103'";
    $result = sisLog( $query);
    $d = mysqli_fetch_object($result);

    $msg_list[] = [
        'to' =>  str_replace(['(',')',' ','-'],false,$d->phoneNumber),
        'message' => "Envio de mensagem Capital Soluções",
        'reference' => "lote-".date("YmdHis")
        ];

    $response = sendMultiple($msg_list);

    // mysqli_query($con, "update clientes set simulacao_10 = '1' where codigo = '{$d->codigo}'");





?>
