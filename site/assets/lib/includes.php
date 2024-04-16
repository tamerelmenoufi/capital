<?php
    date_default_timezone_set("America/Manaus");
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/fn.php");

    // $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/painel/";
    // $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/site/";

    $localPainel = "https://painel.capitalsolucoesam.com.br/";
    $localSite = "https://capitalsolucoesam.com.br/";