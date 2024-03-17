<?php
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");

    $facta = new Facta;

    $retorno = $facta->Simulador1();


    var_dump($retorno);


?>