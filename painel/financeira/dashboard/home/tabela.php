<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $data = (($_POST['data'])?:date("Y-m"));

    $query = "select
                (select count(*) from clientes where data_cadastro like '{$data}%' group by codigo) as novos_cadastros,
                (select count(*) from consultas where data like '{$data}%') as simulacoes,
                (select count(*) from consultas where data like '{$data}%' and dados->>'$.statusCode' = '200') as simulacoes_positiva,
                (select count(*) from consultas where data like '{$data}%' and dados->>'$.statusCode' != '200') as simulacoes_negativa,

                (select count(*) from consultas where data like '{$data}%' and proposta->>'$.statusCode') as propostas,
                (select count(*) from consultas where data like '{$data}%' and proposta->>'$.statusCode' and proposta->>'$.statusCode' = '130') as propostas_pagas,
                (select count(*) from consultas where data like '{$data}%' and proposta->>'$.statusCode' and proposta->>'$.statusCode' in ('200', '95', '60', '61')) as propostas_pendentes,
                (select count(*) from consultas where data like '{$data}%' and proposta->>'$.statusCode' and proposta->>'$.statusCode' not in ('200', '130', '95', '60', '61')) as propostas_erro
            ";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $dados = [
        ['NC', 'Novos Cadastros', $d->novos_cadastros],
        ['SR', 'Simulações Realizadas', $d->simulacoes],
        ['SS', 'Simulações bem Sucedidas', $d->simulacoes_positiva],
        ['SN', 'Simulações Negadas', $d->simulacoes_negativa],
        ['PR', 'Propostas Realizadas', $d->propostas],
        ['AP', 'Antecipação Paga', $d->propostas_pagas],
        ['PP', 'Propostas com Pendências', $d->propostas_pendentes],
        ['PN', 'Propostas Negadas', $d->propostas_erro]
    ];
?>
<h5>Filtro para o período <?=$data?></h5>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col" class="text-center">Sigla</th>
      <th scope="col">Descrição</th>
      <th scope="col" class="text-center">Quanidade</th>
    </tr>
  </thead>
  <tbody>
<?php
    foreach($dados as $item => $valor){
?>
    <tr>
      <td class="text-center"><?=$valor[0]?></td>
      <td><?=$valor[1]?></td>
      <td class="text-center">
        <button
            class="btn btn-primary btn-sm"
            filtro="<?=$valor[0]?>"
            periodo="<?=$data?>"
            data-bs-toggle="offcanvas"
            href="#offcanvasDireita"
            role="button"
            aria-controls="offcanvasDireita"
        >
            <i class="fa-solid fa-arrow-up-right-from-square"></i> <?=$valor[2]?>
        </button>
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
        
      $("button[filtro]").click(function(){

        filtro = $(this).attr("filtro");
        periodo = $(this).attr("periodo");
        Carregando();
        $.ajax({
          url:"financeira/dashboard/home/filtro.php",
          type:"POST",
          data:{
            filtro,
            periodo
          },
          success:function(dados){
            $(".LateralDireita").html(dados);
          }
        })

      })
        
    })
</script>