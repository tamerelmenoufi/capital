<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['acao'] == 'padrao'){

        mysqli_query($con, "update configuracoes set api_tabela_padrao = '{$_POST['id']}' where codigo = '1'");

    }

    $tab_disc = [
        'name' => 'Nome',
        'annualFee' => 'Taxa Anual',
        'monthlyFee' => 'Taxa Mensal',
        'maxDisbursedAmount' => 'Valor Máximo',
        'minDisbursedAmount' => 'Valor Mínimo',
        'maxNumberOfYearsAntecipated' => 'Máximo Antecipação',
        'minNumberOfYearsAntecipated' => 'Mínimo Antecipação',
    ];

    $query = "select * from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $tabelas = json_decode($d->api_tabelas);

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - VCTEX</h5>
  <div class="card-body">
    <h5 class="card-title">Tabelas disponíveis</h5>
    <p class="card-text"><?=var_dump($tabelas)?>

    <table class="table">
        <thead>
            <tr>
            <th scope="col"><?=$tab_disc['name']?></th>
            <th scope="col"><?=$tab_disc['monthlyFee']?></th>
            <th scope="col"><?=$tab_disc['annualFee']?></th>
            <th scope="col"><?=$tab_disc['minDisbursedAmount']?></th>
            <th scope="col"><?=$tab_disc['maxDisbursedAmount']?></th>
            <th scope="col"><?=$tab_disc['minNumberOfYearsAntecipated']?></th>
            <th scope="col"><?=$tab_disc['maxNumberOfYearsAntecipated']?></th>
            <th scope="col">Padrão</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($tabelas->data as $i => $v){
        ?>
            <tr class="<?=(($v->id == $d->api_tabela_padrao)?'bg-primary':false)?>">
                <td><?=$v->name?></td>
                <td><?=$v->monthlyFee?></td>
                <td><?=$v->annualFee?></td>
                <td><?=$v->minDisbursedAmount?></td>
                <td><?=$v->maxDisbursedAmount?></td>
                <td><?=$v->minNumberOfYearsAntecipated?></td>
                <td><?=$v->maxNumberOfYearsAntecipated?></td>
                <td>
                    <input padrao type="checkbox" class="form-check-input" value="<?=$v->id?>" <?=(($v->id == $d->api_tabela_padrao)?'checked':false)?>>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    </p>
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

        $("input[padrao]").click(function(){
            id = $(this).val();
            Carregando();
            $.ajax({
                url:"financeira/vctex/index.php",
                type:"POST",
                data:{
                    acao:'padrao',
                    id
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })


    })
</script>