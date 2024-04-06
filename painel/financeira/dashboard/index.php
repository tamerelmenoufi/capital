<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

?>
<style>
    .calendario{
        width:100%;
    }
    .calendario td{
        font-size:12px;
        text-align:center;
        min-height:25px;
        padding:5px;
        vertical-align:top;
    }

    .calendario th{
        font-size:12px;
        text-align:center;
        min-height:25px;
        padding:5px;
    }
    .registros{
        padding:5px;
        font-size:12px;
        margin:5px;
        width:100%;
        height:25px;
        border-radius:5px;
        background:blue;
        color:#fff;
        cursor:pointer;
    }
    .registros_limpo{
        padding:5px;
        font-size:12px;
        margin:5px;
        width:100%;
        height:25px;
        border-radius:5px;
        background:#fff;
        color:#fff;
    }
</style>
<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira</h5>
  <div class="card-body">
    <h5 class="card-title">Relatórios e estatísticas</h5>
    <p class="card-text">Tela de exibição das informações de consultas, contratos e histórico dos clientes.</p>
    <p class="card-text">Em desenvolvimento. Disponibilidade em breve.</p>
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    <div class="row">
        <div class="col-md-4">
            <div dbCalendar></div>
        </div>
    </div>
  </div>
</div>


<script>
    $(function(){

        Carregando('none');
        $.ajax({
            url:"financeira/dashboard/home/calendario.php",
            success:function(dados){
                $("div[dbCalendar]").html(dados);
            }
        })

    })
</script>