<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    list($Y1,$m1,$d1) = explode("-",$data);
    if($d1) $dt = "{$d1}/{$m1}/{$Y1}";
    else $dt = "{$m1}/{$Y1}";
?>
<h5>Cadastros no período de <?=$dt?></h5>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col" class="text-center">Nome</th>
      <th scope="col">CPF</th>
      <th scope="col" class="text-center">Evolução</th>
    </tr>
  </thead>
  <tbody>
<?php
    $query = "select * from clientes where data_cadastro like '{$data}%'";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>
    <tr>
      <td class="text-center"><?=$d->nome?></td>
      <td><?=$d->cpf?></td>
      <td class="text-center">
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-label="Segment one" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-info" role="progressbar" aria-label="Segment three" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </td>
    </tr>
<?php
    }

?>
  </tbody>
</table>


<script>
    $(function(){
      Carregando('none');
        
      
        
    })
</script>