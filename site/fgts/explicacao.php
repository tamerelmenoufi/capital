<?php

include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

?>

<style>

    .card{
        border-color:#534ab3,
    }
    .card-header{
        background-color:#534ab3;
        color:#fff;
    }
    .card-title{
        font-weight:bold;
        color:#534ab3;
    }
    .card-text{
        color:#534ab3;
    }

</style>

<div class="card" data-aos="zoom-in" data-aos-delay="200">
    <div class="card-header">
        Capital Soluções - especialistas em antecipação de FGTS
    </div>
    <div class="card-body">
        <h5 class="card-title">Assista o vídeo que preparamos para você</h5>
        <p class="card-text">Somos especialistas em antecipação do FGTS e vamos lhe orientar como obter o benefício. Assista com atenção o vídeo e conheça nossa empresa antes de prosseguir.</p>
        
        <div class="mt-2">
            Entrado do Vídeo
        </div>

        <div class="mt-2">
            <button class="btn btn-primary w-100" local="fgts/login.php"><i class="fa-solid fa-angles-right"></i> Legal, quero iniciar.</button>
        </div>

    </div>
    </div>
</div>

<script>
    $(function(){

        $("button[local]").click(function(){
            url = $(this).attr("local");
            $.ajax({
                url,
                success:function(dados){
                    $(".palco").html(dados);
                }
            })
        })

    })
</script>