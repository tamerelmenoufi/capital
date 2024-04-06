<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    $query = "select
                (select count(*) from clientes where data_cadastro like '{$data}%') as novos_cadastros,
                (select count(*) from consultas where data like '{$data}%') as simulacoes,
                (select count(*) from consultas where data like '{$data}%' and dados->>'$.statusCode' = '200') as simulacoes_positiva,
                (select count(*) from consultas where data like '{$data}%' and dados->>'$.statusCode' != '200') as simulacoes_negativa,
                (select count(*) from consultas where data like '{$data}%' and proposta is not null) as propostas,
                (select count(*) from consultas where data like '{$data}%' and proposta is not null and proposta->>'$.statusCode' = '130') as propostas_pagas,
                (select count(*) from consultas where data like '{$data}%' and proposta is not null and proposta->>'$.statusCode' in ('200', '95', '60', '61')) as propostas_pendentes,
                (select count(*) from consultas where data like '{$data}%' and proposta is not null and proposta->>'$.statusCode' not in ('200', '130', '95', '60', '61')) as propostas_erro
            ";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $dados = [
        'Novos Cadastros' => $d->novos_cadastros,
        'Simulações Realizadas' => $d->simulacoes,
        'Simulações bem sucedidas' => $d->simulacoes_positiva,
        'Simulações Negadas' => $d->simulacoes_negativa,
        'Propostas Realizadas' => $d->propostas,
        'Antecipação Paga' => $d->propostas_pagas,
        'Propostas com Pendências' => $d->propostas_pendentes,
        'Propostas Negadas' => $d->propostas_erro
    ];
?>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Descrição</th>
      <th scope="col">Quanidade</th>
    </tr>
  </thead>
  <tbody>
<?php
    foreach($dados as $item => $valor){
?>
    <tr>
      <td><?=$item?></td>
      <td><?=$valor?></td>
    </tr>
<?php
    }

?>
  </tbody>
</table>


<script>
    $(function(){
        
        
    })
</script>