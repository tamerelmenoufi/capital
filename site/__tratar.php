<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/site/assets/lib/includes.php");
    exit();
    $query = "SELECT a.codigo, a.cpf, a.cadastro_percentual, (select count(*) from clientes where cpf = a.cpf) as `qt` FROM clientes a where a.cpf != '' group by a.cpf, a.codigo ORDER BY qt desc, a.cpf";
    $result = mysqli_query($con, $query);
    $duplicado = [];
    $delete = [];
    while($d = mysqli_fetch_object($result)){

        if($d->qt > 1){
            if(!$duplicado[$d->cpf]) $duplicado[$d->cpf] = $d->codigo;
            else{
                $delete[] = $d->codigo;
            }
        }

    }
    $delete = implode(",",$delete);
    echo $query = "delete from clientes where codigo in({$delete})";