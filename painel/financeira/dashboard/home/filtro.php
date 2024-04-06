<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

        $periodo = explode("-",$_POST['periodo']);
        if($periodo[2]) $periodo = "{$periodo[2]}/{$periodo[1]}/{$periodo[0]}";
        else $periodo = "{$periodo[1]}/{$periodo[0]}";

        $dicionario = [
            'NC' => 'Novos Cadastros',
            'SR' => 'Simulações Realizadas',
            'SS' => 'Simulações bem Sucedidas',
            'SN' => 'Simulações Negadas',
            'PR' => 'Propostas Realizadas',
            'AP' => 'Antecipação Paga',
            'PP' => 'Propostas com Pendências',
            'PN' => 'Propostas Negadas'
        ];

        $querys = [
            'NC' => "select a.*, (select log from consultas_log where cliente = a.codigo order by codigo desc limit 1) as log from clientes a where a.data_cadastro like '{$_POST['periodo']}%'",
            'SR' => "select a.dados as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%'",
            'SS' => "select a.dados as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and a.dados->>'$.statusCode' = '200'",
            'SN' => "select a.dados as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and a.dados->>'$.statusCode' != '200'",
            'PR' => "select a.proposta as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and proposta->>'$.statusCode'",
            'AP' => "select a.proposta as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and proposta->>'$.statusCode' and proposta->>'$.statusCode' = '130'",
            'PP' => "select a.proposta as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and proposta->>'$.statusCode' and proposta->>'$.statusCode' in ('200', '95', '60', '61')) as propostas_pendentes",
            'PN' => "select a.proposta as log, b.* from consultas a left join clientes b on a.cliente = b.codigo where a.data like '{$_POST['periodo']}%' and proposta->>'$.statusCode' not in ('200', '130', '95', '60', '61')) as propostas_erro"
        ];


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

<h4 class="Titulo<?=$md5?>"><?=$dicionario[$_POST['filtro']]?></h4>


<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Período de <?=$periodo?> </h5>
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
                  $query = $querys[$_POST['filtro']];
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