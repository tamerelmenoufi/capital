<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    list($Y1,$m1,$d1) = explode("-",$data);
    if($d1) $dt = "{$d1}/{$m1}/{$Y1}";
    else $dt = "{$m1}/{$Y1}";
?>
<h5>Cadastros no período de <?=$dt?></h5>

<div class="d-none d-md-block">
    <div class="row">
        <div class="col-md-5 fw-bold">Nome</div>
        <div class="col-md-2 fw-bold">CPF</div>
        <div class="col-md-1 fw-bold text-center">Pré-cadastro</div>
        <div class="col-md-1 fw-bold text-center">Autorização</div>
        <div class="col-md-1 fw-bold text-center">Simulação</div>
        <div class="col-md-1 fw-bold text-center">Cadastro</div>
        <div class="col-md-1 fw-bold text-center">Contrato</div>
    </div>
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
    <div class="row bg-success bg-opacity-10 p-2 border-bottom">
        <div class="col-md-5"><?=(($d->nome)?:'<span class="text-danger">Sem Identificação</span>')?></div>
        <div class="col-md-2"><?=(($d->cpf)?:'<span class="text-danger">000.000.000-00</span>')?></div>
        <div class="col-md-1">
            <div class="d-block d-md-none d-lg-none d-xl-none d-xxl-none"><i class="fa-regular fa-circle"></i> Pré-cadastro</div>
            <div class="d-none d-md-block text-center"><i class="fa-regular fa-circle"></i></div>
        </div>
        <div class="col-md-1">
            <div class="d-block d-md-none d-lg-none d-xl-none d-xxl-none"><i class="fa-regular fa-circle"></i> Autorização</div>
            <div class="d-none d-md-block text-center"><i class="fa-regular fa-circle"></i></div>
        </div>
        <div class="col-md-1">
            <div class="d-block d-md-none d-lg-none d-xl-none d-xxl-none"><i class="fa-regular fa-circle"></i> Simulação</div>
            <div class="d-none d-md-block text-center"><i class="fa-regular fa-circle"></i></div>
        </div>
        <div class="col-md-1">
            <div class="d-block d-md-none d-lg-none d-xl-none d-xxl-none"><i class="fa-regular fa-circle"></i> Cadastro</div>
            <div class="d-none d-md-block text-center"><i class="fa-regular fa-circle"></i></div>
        </div>
        <div class="col-md-1">
            <div class="d-block d-md-none d-lg-none d-xl-none d-xxl-none"><i class="fa-regular fa-circle"></i> Contrato</div>
            <div class="d-none d-md-block text-center"><i class="fa-regular fa-circle"></i></div>
        </div>
        
        
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