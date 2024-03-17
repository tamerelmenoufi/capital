<?php
    include("/capitalinc/connect.php");
    $con = AppConnect('capital');
    include("classes.php");
?>

<h3>Sistema de Assessoria Financeira</h3>

<?php

$facta = new Facta;

echo $token = $facta->Token();

?>