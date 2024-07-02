<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $querys = file_get_contents("teste.sql");
    $linhas = explode("\n", $querys);

    for($i = 0; $i < count($linhas); $i++){

        echo $linhas[$i];
        mysqli_query($con, $linhas[$i]);
        echo "<br>";

    }