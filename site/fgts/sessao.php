<?php

    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['codUsr']) $_SESSION['codUsr'] = $_POST['codUsr'];
    echo $_SESSION['codUsr'];