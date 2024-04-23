<?php
    $dados = file_get_contents("dados.csv");

    $linhas = explode("\n",$dados);

    $query = "INSERT INTO banco (cpf, nome, telefone) VALUES ";
    $data = [];
    $i=0;
    foreach($linhas as $i => $colunas){

        $cols = explode("   ",$colunas);
        $data = [$cols[0], $cols[1], $cols[2]];

        if($i%100 == 0 and $i > 0){
            echo $query."('".implode("'),('")."');</br></br>";
        }
        $i++;
    }