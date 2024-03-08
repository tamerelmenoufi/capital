<?php

    include("classes.php");

    $vctex = new Vctex;

    // echo $retorno = $vctex->Token();

    $token = "eyJhbGciOiJIUzI1NiJ9.eyJpZCI6IjRjOWZhODZlLWY3ZmYtNDJjNC04N2FmLWI5NjExYjAyZDVjYSIsImlhdCI6MTcwOTkxMzI0NywiaXNzIjoidmN0ZXhfdGVzdCIsImF1ZCI6InZjdGV4X3Rlc3QiLCJleHAiOjE3MDk5MjA0NDd9.k6jWn5akclGnSzTYM75wx8hM2354g6A3d-gxkrTKjn8";

    // echo $retorno = $vctex->Tabelas($token);
    // echo $retorno = $vctex->Simular($token);
    echo $retorno = $vctex->Credito($token);
