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

<h4 class="Titulo<?=$md5?>">Últimas Conversas</h4>


<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Lista de Clientes </h5>
          <div class="card-body">

            <div class="table-responsive">
            <table class="table table-striped table-hover">
              <!-- <thead>
                <tr>
                  <th scope="col">#</th> -->
                  <!-- <th scope="col">Código</th> -->
                  <!-- <th scope="col">Nome</th>
                  <th scope="col">CPF</th>
                  <th scope="col">Situação</th>
                </tr>
              </thead> -->
              <tbody>
                <?php
                  $query = "select 
                                    max(a.codigo) as cod,
                                    (select mensagem from wapp_chat where max(a.codigo) = codigo) as mensagem,
                                    b.nome,
                                    b.status_atual as log
                                    
                            from wapp_chat a left join clientes b on a.de = REPLACE(REPLACE(REPLACE(REPLACE(b.phoneNumber, '(', ''), ')', ''), '-', ''), ' ', '') 
                            where a.de != '{$ConfWappNumero}' 
                            group by a.de 
                            order by a.data desc 
                            limit 100";
                  $result = mysqli_query($con, $query);
                  $k = 1;
                  while($d = mysqli_fetch_object($result)){

                    // $log = json_decode($d->log);

                    // if($log->statusCode and $log->message){
                    //   $situacao = "{$log->statusCode} - {$log->message}";
                    // }else{
                    //   $situacao = "Situação detalhada não identificada";
                    // }
                    

                    // if($log->statusCode and $_POST['filtro'] == 'NC'){
                    //   $situacao = "{$log->statusCode} - {$log->message}";
                    //   $cor="orange";
                    // }else if($log->proposalStatusId and $_POST['filtro'] == 'NC'){
                    //   $situacao = "{$log->proposalStatusId} - {$log->proposalStatusDisplayTitle}";
                    //   if($log->proposalStatusId == 130){
                    //     $cor="green";
                    //   }else{
                    //     $cor="red";
                    //   }
                    // }else if($_POST['filtro'] == 'NC'){
                    //   $situacao = "000 - Cliente sem movimentação";
                    //   $cor="#ccc";
                    // }else if(in_array($log->statusCode, ['200'])){
                    //   $cor="orange";
                    // }else if(!in_array($log->statusCode, ['200']) and $_POST['filtro'] == 'SN'){
                    //   $cor="red";
                    // }else if(in_array($log->statusCode, ['130'])){
                    //   $cor="green";
                    // }else if(in_array($log->statusCode, ['200', '95', '60', '61'])){
                    //   $cor="orange";
                    // }else if(in_array($log->statusCode, ['200', '130', '95', '60', '61'])){
                    //   $cor="red";
                    // }else{
                    //   $cor="red";
                    // }
                    list($mensagem, $data) = explode("^",$d->mensagem);
                ?>
                <tr>

                  <td>
                    <div class="d-flex justify-content-between">
                      <div class="p-2" style="font-size:12px;"><i class="fa-solid fa-user"></i> <?=(($d->nome)?:"<span class='text-danger'>Sem Identificação</span>")?></div>
                      <div class="p-2" style="font-size:12px;"><i class="fa-solid fa-id-card"></i> <?=(($d->phoneNumber)?:"<span class='text-danger'>Não Registrado</span>")?> (<?=$d->phoneNumber?>)</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="legenda_status p-2" style="border-left-color:<?=$cor?>; font-size:12px; color:#a1a1a1;">
                        <span style="color:#333"><?=$mensagem?></span><br><?=dataBr($data)?>
                      </div>
                    </div>
                  </td>




                  <!-- <td><?=$k?></td>-->
                  <!-- <td><?=$d->cod_cliente?></td> -->
                  <!-- <td><?=$d->nome?></td>
                  <td><?=$d->cpf?></td>
                  <td class="legenda_status" style="border-left-color:<?=$cor?>;">
                    <?=$situacao?>
                  </td>  -->


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