<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .listaWapp{
        position:relative;
    }
    .mensagensaWapp{
        position:relative;
    }
</style>
<div class="row g-0">
    <div class="col-12">
        <div class="d-flex justify-content-end">
            <i class="fa-solid fa-xmark fechaPopupWapp m-3" style="font-size:20px; cursor:pointer"></i>
        </div>
    </div>
</div>
<div class="row g-0">
    <div class="col-4 listaWapp"></div>
    <div class="col-8 mensagensaWapp"></div>
</div>

<script>
    $(function(){
        Carregando('none')

        $(".fechaPopupWapp").click(function(){
            $(".popupWapp").css("display","none");
            $(".popupWapp").html('');
        })
        
        $.ajax({
            url:"financeira/wapp/wapp_lista.php",
            success:function(dados){
                $(".listaWapp").html(dados);
            }
        })

        $.ajax({
            url:"financeira/wapp/wapp.php",
            success:function(dados){
                $(".mensagensWapp").html(dados);
            }
        })
    })
</script>