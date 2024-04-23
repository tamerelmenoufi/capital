<?php
    exit();
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
    $dados = file_get_contents("dados.csv");

    $linhas = explode("\n",$dados);

    $query = "INSERT INTO banco (cpf, nome, telefone) VALUES ";
    $data = [];
    $i=0;
    foreach($linhas as $i => $colunas){
        set_time_limit(100);
        $cols = explode("	",$colunas);
        $data[] = "('{$cols[0]}', '{$cols[1]}', '{$cols[2]}')";

        if($i%100 == 0 and $i > 0){
            $comando = $query.implode(", ",$data);
            mysqli_query($con, $comando);
            echo $i.", ";
        }
        $i++;

    }