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
        $tabelas = $vctex->Tabelas($d->token);
    }else{
        $retorno = $vctex->Token();
        $dados = json_encode($retorno);
        if($dados->statusCode == 200){
            echo "Expira: ".$dados['token']['expires']. "<br>";
            echo "Retorno: ".print_r($dados). "<br>";

            mysqli_query($con, "update configuracoes set api_expira = '".($agora + $dados['token']['expires'])."', api_dados = '{$retorno}' where codigo = '1'");
        }
    }

    if($tabelas){
        echo "<h1>Tabelas</h1>";

        echo $tabelas;

        echo "<hr>";
    }else{

        echo "<h1>Conexão</h1>";

        echo $retorno;

        echo "<hr>";

        echo print_r($dados);
    }
exit();


    // echo $retorno = $vctex->Token();

    $token = "eyJhbGciOiJIUzI1NiJ9.eyJpZCI6IjRjOWZhODZlLWY3ZmYtNDJjNC04N2FmLWI5NjExYjAyZDVjYSIsImlhdCI6MTcwOTkxMzI0NywiaXNzIjoidmN0ZXhfdGVzdCIsImF1ZCI6InZjdGV4X3Rlc3QiLCJleHAiOjE3MDk5MjA0NDd9.k6jWn5akclGnSzTYM75wx8hM2354g6A3d-gxkrTKjn8";

    echo $retorno = $vctex->Tabelas($token);
    // echo $retorno = $vctex->Simular($token);
    // echo $retorno = $vctex->Credito($token);
