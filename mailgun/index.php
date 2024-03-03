<?php

    date_default_timezone_set("America/Manaus");
    include("/pfgeoinc/connect.php");
    $con = AppConnect('emails');


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = json_decode(file_get_contents('php://input'), true);

    $mailgun = addslashes(json_encode($_POST));
    // $post = print_r($_POST, true)."\n<hr>\n".print_r($_GET, true);

    $result = mysqli_query($con, "insert into mailgun set email = '{$mailgun}', data = NOW()");
    $registro = mysqli_insert_id($con);

    $attachments = json_decode($_POST['attachments']);
    $dados = false;
    foreach($attachments as $ind => $arq){
        $dados .= "Nome: ".$arq->name."\n";
        $opc = 'content-type';
        $dados .= "Type: ".$arq->$opc."\n";
        $dados .= "Size: ".$arq->size."\n";
        $dados .= "url: ".$arq->url."\n\n\n";

        $arquivo = file_get_contents(str_replace("://","://api:key-f084b8985ece92fcbbc2948cfe7f855f@",$arq->url));

        if(!is_dir("anexos/{$registro}")) mkdir("anexos/{$registro}");

        file_put_contents("anexos/{$registro}/{$arq->name}", $arquivo);

    }

    // file_put_contents('anexos/'.date("YmdHis").".txt", $post."\n\n\n".$dados);

    //Teste