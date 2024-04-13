<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $query = "select * from consultas_log where cliente = '{$_POST['cliente']}' order by data desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        echo $d->sessoes;
        echo "<br><br>";
        echo $d->log;
        echo "<hr>";
    }