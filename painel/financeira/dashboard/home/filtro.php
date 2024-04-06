<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
  .legenda_status{
    border-left:5px solid;
    border-left-color:green;
  }
  .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }

</style>

<h4 class="Titulo<?=$md5?>"><?=$_POST['filtro']?> - <?=$_POST['periodo']?></h4>


<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Lista de Clientes </h5>
          <div class="card-body">

            <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nome</th>
                  <th scope="col">CPF</th>
                  <th scope="col">Situação</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "select a.*, (select log from consultas_log where cliente = a.codigo order by codigo desc limit 1) as log from clientes a order by a.data_cadastro desc";
                  $result = mysqli_query($con, $query);
                  $k = 1;
                  while($d = mysqli_fetch_object($result)){

                    $log = json_decode($d->log);
                    $del = 'disabled';
                    if($log->statusCode){
                      $situacao = "{$log->statusCode} - {$log->message}";
                      $cor="orange";
                    }else if($log->proposalStatusId){
                      $situacao = "{$log->proposalStatusId} - {$log->proposalStatusDisplayTitle}";
                      if($log->proposalStatusId == 130){
                        $cor="green";
                      }else{
                        $cor="red";
                      }
                    }else{
                      $situacao = "000 - Cliente sem movimentação";
                      $cor="#ccc";
                      $del = false;
                    }

                ?>
                <tr>
                  <td><?=$k?></td>
                  <td><?=$d->nome?></td>
                  <td><?=$d->cpf?></td>
                  <td class="legenda_status" style="border-left-color:<?=$cor?>;">
                    <?=$situacao?>
                  </td>
                </tr>
                <?php
                $k++;
                  }
                ?>
              </tbody>
            </table>
                </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


<script>
    $(function(){
        Carregando('none');
 
    })
</script>