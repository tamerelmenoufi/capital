<?php
    function AppConnect($db = 'pfgeo'){
        $con = mysqli_connect("pfgeotecnologia.com.br:8033","root","","SenhaDoBanco");
        mysqli_set_charset( $con, 'utf8');
        return $con;
    }