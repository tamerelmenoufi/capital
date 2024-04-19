<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $c = mysqli_fetch_object(mysqli_query($con, "select * from clientes where codigo = '{$_POST['mensagens']}'"));

?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
    .topo<?=$md5?>{
        position:absolute;
        background:#eee;
        left:0;
        right:0;
        height:40px;
        top:50px;
        padding:10px;
    }
    .palco<?=$md5?>{
        position:absolute;
        background:yellow;
        left:0;
        right:0;
        bottom:150px;
        top:90px;        
    }    
    .rodape<?=$md5?>{
        position:absolute;
        background:#a1a1a1;
        left:0;
        right:0;
        bottom:0px;    
        height:150px;    
    }
</style>
<h4 class="Titulo<?=$md5?>">Mensagens WhatsApp</h4>
<div class="topo<?=$md5?>"><i class="fa-regular fa-comment-dots"></i> <?=$c->nome?></div>
<div class="palco<?=$md5?>"></div>
<div class="rodape<?=$md5?>"></div>

