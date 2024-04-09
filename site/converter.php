<?php

    $lista = file_get_contents("converter.csv");
    $linhas = explode("\n", $dados);

    foreach($linhas as $i => $l){
        echo $l."<hr>";
    }

?>