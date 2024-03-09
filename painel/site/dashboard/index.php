<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<div class="row g-0">
    <div class="m-3"></div>
<?php

    $placas = [
        'banners' => 'Banners',
        'servicos' => 'Produtos',
        'time' => 'Time da empresa',
        'depoimentos' => 'Depoimentos',
    ];

    foreach($placas as $tabela => $titulo){
        $r = mysqli_query($con, "select count(*) as qt, situacao from {$tabela} group by situacao");
        $total = $bloqueado = $liberado;
        while($p = mysqli_fetch_object($r)){
            $total += $p->qt;
            if($p->situacao != 1) $bloqueado += $p->qt;
            else $liberado += $p->qt;
        }

?> 
<div class="col p-3">
    <div class="alert alert-primary" style="height:90px;">
        <b><?=$titulo?></b>
        <h2><?=$total?></h2>
    </div>
</div>
<?php
    }
?>
</div>
<script>
    $(function(){

        Carregando('none');


    })
</script>