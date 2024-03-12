<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

$query = "select * from configuracoes where codigo = '1'";
$result = mysqli_query($con, $query);
$d = mysqli_fetch_object($result);

$tabelas = json_decode($d->api_tabelas);

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - VCTEX</h5>
  <div class="card-body">
    <h5 class="card-title">Tabelas disponíveis</h5>
    <p class="card-text"><?=var_dump($tabelas)?></p>
    <button atualiza class="btn btn-primary">Atualizar</button>
  </div>
</div>


<script>
    $(function(){

        Carregando('none');

        $("button[atualiza]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/vctex/index.php",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })


    })
</script>