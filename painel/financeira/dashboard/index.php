<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $query = "select
                (select count(*) from clientes) as clientes,
                (select count(*) from consultas) as simulacoes,
                (select count(*) from consultas where proposta->>'$.statusCode') as contratos,
                (select count(*) from consultas where proposta->>'$.statusCode' = '130') as pagos,
                (select sum(dados->'$.data.simulationData.totalReleasedAmount') from consultas where proposta->>'$.statusCode' = '130') as valor
            ";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

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
    .alert div{
        font-size:12px;
        color:#a1a1a1;
        text-align:left;
    }
    .alert h1{
        text-align:center;
    }
</style>
<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira</h5>
  <div class="card-body">


<!-- <div class="alert alert-secondary" role="alert">
A simple secondary alert—check it out!
</div>
<div class="alert alert-success" role="alert">
A simple success alert—check it out!
</div>
<div class="alert alert-danger" role="alert">
A simple danger alert—check it out!
</div>
<div class="alert alert-warning" role="alert">
A simple warning alert—check it out!
</div> -->


    <div class="row">
        <div class="col-md-2">
            <div class="alert alert-primary" role="alert">
                <div>Clientes</div>
                <h1><?=$d->clientes?></h1>
            </div>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary" role="alert">
                <div>Simulações</div>
                <h1><?=$d->simulacoes?></h1>
            </div>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary" role="alert">
                <div>Contratos</div>
                <h1><?=$d->contratos?></h1>
            </div>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary" role="alert">
                <div>Contratos Pagos</div>
                <h1><?=$d->pagos?></h1>
            </div>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary" role="alert">
                <div>Valor Acumulado</div>
                <h1><?=$d->valor?></h1>
            </div>
        </div>
    </div>





    <h5 class="card-title">Relatórios e estatísticas</h5>
    <p class="card-text">Tela de exibição das informações de consultas, contratos e histórico dos clientes.</p>
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
    <div class="row">
        <div class="col-md-4">
            <div dbCalendar></div>
        </div>
        <div class="col-md-8">
            <div dbTabela></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div dbCadastros></div>
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
                
                dateN = ("00" + $("select[dateN]").val()).slice(-2);
                dateY = $("select[dateY]").val();

                $.ajax({
                    url:"financeira/dashboard/home/tabela.php",
                    type:"POST",
                    data:{
                        data:`${dateY}-${dateN}`
                    },
                    success:function(dados){
                        $("div[dbTabela").html(dados);
                    }
                })

                $.ajax({
                    url:"financeira/dashboard/home/cadastros.php",
                    type:"POST",
                    data:{
                        data:`${dateY}-${dateN}`
                    },
                    success:function(dados){
                        $("div[dbCadastros").html(dados);
                    }
                })
                
            }
        })



    })
</script>