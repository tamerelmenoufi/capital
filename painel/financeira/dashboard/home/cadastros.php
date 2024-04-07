<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    list($Y1,$m1,$d1) = explode("-",$data);
    if($d1) $dt = "{$d1}/{$m1}/{$Y1}";
    else $dt = "{$m1}/{$Y1}";
?>
<h5>Cadastros no período de <?=$dt?></h5>

<div class="row">
    <div class="col-md-5">Nome</div>
    <div class="col-md-2">CPF</div>
    <div class="col-md-1">Pré-cadastro</div>
    <div class="col-md-1">Autorização</div>
    <div class="col-md-1">Simulação</div>
    <div class="col-md-1">Cadastro</div>
    <div class="col-md-1">Contrato</div>
</div>


<!-- <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col" class="text-center">Nome</th>
      <th scope="col">CPF</th>
      <th scope="col" class="text-center">Pré-cadastro</th>
      <th scope="col" class="text-center">Autorização</th>
      <th scope="col" class="text-center">Simulação</th>
      <th scope="col" class="text-center">Cadastro</th>
      <th scope="col" class="text-center">Contrato</th>
    </tr>
  </thead>
  <tbody> -->
<?php
    $query = "select * from clientes where data_cadastro like '{$data}%'";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>
    <div class="row bg-light">
        <div class="col-md-5"><?=$d->nome?></div>
        <div class="col-md-2"><?=$d->cpf?></div>
        <div class="col-md-1 text-center"><i class="fa-regular fa-circle"></i></div>
        <div class="col-md-1 text-center"><i class="fa-regular fa-circle"></i></div>
        <div class="col-md-1 text-center"><i class="fa-regular fa-circle"></i></div>
        <div class="col-md-1 text-center"><i class="fa-regular fa-circle"></i></div>
        <div class="col-md-1 text-center"><i class="fa-regular fa-circle"></i></div>
    </div>
    
    <!-- <tr>
      <td class="text-center"><?=$d->nome?></td>
      <td><?=$d->cpf?></td>
      <td class="text-center"><i class="fa-regular fa-circle"></i></td>
      <td class="text-center"><i class="fa-regular fa-circle"></i></td>
      <td class="text-center"><i class="fa-regular fa-circle"></i></td>
      <td class="text-center"><i class="fa-regular fa-circle"></i></td>
      <td class="text-center"><i class="fa-regular fa-circle"></i></td>
    </tr> -->


<?php
    }

?>
  <!-- </tbody>
</table> -->


<script>
    $(function(){
      Carregando('none');
        
      
        
    })
</script>