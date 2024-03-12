<?php
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");

    $vctex = new Vctex;

    $query = "select *, api_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $agora = time();

    if($agora < $d->api_expira){
        $tabelas = $d->api_tabelas;
    }else{
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
            mysqli_query($con, "update configuracoes set api_expira = '".($agora + $dados->token->expires)."', api_dados = '{$retorno}', api_tabelas = '{$tabelas}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }


    echo "<h1>Tabelas</h1>";

    echo $tabelas;

    echo "<hr>";


exit();


    // echo $retorno = $vctex->Token();

    $token = "eyJhbGciOiJIUzI1NiJ9.eyJpZCI6IjRjOWZhODZlLWY3ZmYtNDJjNC04N2FmLWI5NjExYjAyZDVjYSIsImlhdCI6MTcwOTkxMzI0NywiaXNzIjoidmN0ZXhfdGVzdCIsImF1ZCI6InZjdGV4X3Rlc3QiLCJleHAiOjE3MDk5MjA0NDd9.k6jWn5akclGnSzTYM75wx8hM2354g6A3d-gxkrTKjn8";

    // echo $retorno = $vctex->Tabelas($token);
    
    // echo $retorno = $vctex->Simular($token);
    // echo $retorno = $vctex->Credito($token);
