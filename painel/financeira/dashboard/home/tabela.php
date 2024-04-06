<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    $query = "select
                (select count(*) from clientes where data_cadastro like '{$data}%') as novos_cadastros,
                (select count(*) from consultas where data like '{$data}%') as novos_cadastros,
            ";

?>



<script>
    $(function(){
        
        
    })
</script>