<?php

    $lista = file_get_contents("converter.csv");
    $linhas = explode("\n", $lista);

    foreach($linhas as $i => $l){
        if($i>0){
            echo $l."<hr>";
        }
    }

?>