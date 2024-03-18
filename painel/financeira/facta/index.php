<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['acao'] == 'padrao'){

        mysqli_query($con, "update configuracoes set api_facta_tabela_padrao = '{$_POST['id']}' where codigo = '1'");

    }




    $facta = new facta;

    $query = "select *, api_facta_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $agora = time();

    if($agora < $d->api_expira){
        $tabelas = $d->api_facta_tabelas;
    }else{
        $retorno = $facta->Token();
        $dados = json_decode($retorno);
        $tabelas = '{
            "data":{
                {"id":"40703", "name":"Tabela GOLD", "taxa":"2.04"},
                {"id":"40711", "name":"Tabela PLUS", "taxa":"2.04"},
                {"id":"40762", "name":"Tabela FLEX", "taxa":"1.89"},
                {"id":"40770", "name":"Tabela FLEX 1", "taxa":"1.75"},
                {"id":"40789", "name":"Tabela FLEX 2", "taxa":"1.69"}
            }
        }';
        if($dados->statusCode == 200){
            mysqli_query($con, "update configuracoes set api_expira = '".($agora + $dados->token->expires)."', api_facta_dados = '{$retorno}', api_facta_tabelas = '{$tabelas}' where codigo = '1'");
        }
    }

    $tabelas = json_decode($d->api_facta_tabelas);

    var_dump($tabelas);

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - FACTA</h5>
  <div class="card-body">
    <h5 class="card-title">Tabelas disponíveis</h5>
    <p class="card-text">
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
                <tr class="<?=(($v->id == $d->api_facta_tabela_padrao)?'bg-info bg-gradient':false)?>">
                    <td><?=$v->name?></td>
                    <td><?=$v->monthlyFee?></td>
                    <td><?=$v->annualFee?></td>
                    <td><?=$v->minDisbursedAmount?></td>
                    <td><?=$v->maxDisbursedAmount?></td>
                    <td><?=$v->minNumberOfYearsAntecipated?></td>
                    <td><?=$v->maxNumberOfYearsAntecipated?></td>
                    <td>
                        <input padrao type="checkbox" class="form-check-input" value="<?=$v->id?>" <?=(($v->id == $d->api_facta_tabela_padrao)?'checked':false)?>>
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
                url:"financeira/facta/index.php",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })

        $("input[padrao]").click(function(){
            id = $(this).val();
            Carregando();
            $.ajax({
                url:"financeira/facta/index.php",
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