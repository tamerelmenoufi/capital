<?php
    session_start();

    // include("connect_local.php");

    include("/capitalinc/connect.php");
    $con = AppConnect('capital');

    // include("/appinc/connect.php");
    include("fn.php");

    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/vendor/api/vctex.php");
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/vendor/api/facta.php");

    $md5 = md5(date("YmdHis"));

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/painel/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]."/site/";
