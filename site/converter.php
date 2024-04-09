<?php

    $lista = file_get_contents("converter.csv");
    $linhas = explode("\n", $lista);

    foreach($linhas as $i => $l){
        if($i>0){
            $c = explode("	",$l);
            echo $c[0]."<hr>";
        }
    }

?>