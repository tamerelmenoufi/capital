<?php

    $lista = file_get_contents("converter.csv");
    $linhas = explode("\n", $lista);

    foreach($linhas as $i => $l){
        if($i > 0){
            $c = explode("	",$l);
            echo trim($c[0])."<br>".
            trim($c[1])."<br>".
            trim($c[2])."<br>".
            "<hr>";
        }
    }

?>