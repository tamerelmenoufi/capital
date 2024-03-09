<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
Relatórios
<div class="row g-0">
    <div class="m-3"></div>
<?php

    $placas = [
        'banners' => 'Nammers',
        'servicos' => 'Produtos',
        'time' => 'Time da empresa',
        'depoimentos' => 'Depoimentos',
    ];
    
    foreach($placas as $tabela => $titulo){
?> 
<div class="col p-3">
    <div class="alert alert-primary" style="height:90px;">
        <h2><?=$titulo?></h2>
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