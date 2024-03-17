<?php
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");

    $facta = new Facta;

    $retorno = $facta->Calculo();

    var_dump($retorno);


?>