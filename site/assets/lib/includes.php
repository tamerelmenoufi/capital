<?php
    date_default_timezone_set("America/Manaus");
    include("/pfgeoinc/connect.php");
    $con = AppConnect('pfgeo');
    include("classes.php");

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/painel/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/site/";