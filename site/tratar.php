<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/site/assets/lib/includes.php");

    $query = "SELECT a.codigo, a.cpf, a.cadastro_percentual, (select count(*) from clientes where cpf = a.cpf) as `qt` FROM clientes a where a.cpf != '' group by a.cpf, a.codigo ORDER BY qt desc, a.cpf";
    $result = mysqli_query($con, $query);
    $duplicado = [];
    $delete = [];
    while($d = mysqli_fetch_object($result)){

        if($d->qt > 1){
            if(!$duplicado) $duplicado[$d->cpf] = $d->codigo;
            else{
                $delete[] = $d->codigo;
            }
        }

    }

    var_dump($delete);