<?php
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");

    $facta = new Facta;

    // $retorno = $facta->Token();
    $retorno = $facta->Saldo();
    

    var_dump($retorno);


?>