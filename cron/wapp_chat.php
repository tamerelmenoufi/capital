<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $retorno = [ "type" => "chat", "text" => date("Y-m-d H:i:s")];
    
    echo json_encode($retorno);