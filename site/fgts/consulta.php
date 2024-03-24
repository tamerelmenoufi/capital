<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function numero($v){
        $remove = [" ","/","-",".","(",")"];
        return str_replace($remove, false, $v);
    }

    $vctex = new Vctex;

    $query = "select *, api_vctex_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $token = $d->token;
    $tabela_padrao = $d->api_vctex_tabela_padrao;

    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
            $token = $dados->token->accessToken;
            mysqli_query($con, "update configuracoes set api_vctex_expira = '".($agora + $dados->token->expires)."', api_vctex_dados = '{$retorno}', api_vctex_tabelas = '{$tabelas}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }


    if($_POST['acao'] == 'atualiza_proposta'){

        $consulta = $vctex->Conculta([
            'token' => $token,
            'proposalId' => $_POST['proposalId']
        ]);
        $retorno = json_decode($consulta);
        $status_cod = $retorno->proposalStatusId;
        $status_msg = $retorno->proposalStatusDisplayTitle;

        $query = "update `consultas` set 
                                        proposta = JSON_SET(proposta, '$.statusCode', '{$status_cod}'),
                                        proposta = JSON_SET(proposta, '$.message', '{$status_msg}')
                        where codigo = '{$_POST['atualiza_proposta']}'";

        $result = mysqli_query($con, $query);

    }


    if($_POST['acao'] == 'simulacao'){

        $query = "select * from clientes where codigo = '{$_SESSION['codUsr']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        //$tabela_padrao = $tabela_padrao;
        $tabela_escolhida = $tabela_padrao;

        $simulacao = $vctex->Simular([
            'token' => $token,
            'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
            'tabela' => $tabela_padrao
        ]);
        
        $verifica = json_decode($simulacao);
        // var_dump($verifica);
        if($verifica->data->isExponentialFeeScheduleAvailable == true and $verifica->statusCode == 200){

            $simulacao = $vctex->Simular([
                'token' => $token,
                'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
                'tabela' => 0
            ]);

            $tabela_padrao = 0;

        }


        $consulta = uniqid();


        $query = "insert into consultas set 
                                            consulta = '{$consulta}',
                                            operadora = 'VCTEX',
                                            cliente = '{$_SESSION['codUsr']}',
                                            data = NOW(),
                                            tabela_escolhida = '{$tabela_escolhida}',
                                            tabela = '{$tabela_padrao}',
                                            dados = '{$simulacao}'
                                            ";
        mysqli_query($con, $query);
        // exit();

    }

    if($_POST['acao'] == 'proposta'){

        $query = "select 
                        b.*,
                        a.tabela,
                        a.dados->>'$.data.financialId' as financialId
                    from consultas a
                         left join clientes b on a.cliente = b.codigo
                    where a.codigo = '{$_POST['proposta']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        $proposta = $vctex->Credito([
            'token' => $token,
            'json' => "{
                            \"feeScheduleId\": {$d->tabela},
                            \"financialId\": \"{$d->financialId}\",
                            \"borrower\": {
                            \"name\": \"{$d->nome}\",
                            \"cpf\": \"".numero($d->cpf)."\",
                            \"birthdate\": \"{$d->birthdate}\",
                            \"gender\": \"{$d->gender}\",
                            \"phoneNumber\": \"".numero($d->phoneNumber)."\",
                            \"email\": \"{$d->email}\",
                            \"maritalStatus\": \"{$d->maritalStatus}\",
                            \"nationality\": \"{$d->nationality}\",
                            \"naturalness\": \"{$d->naturalness}\",
                            \"motherName\": \"{$d->motherName}\",
                            \"fatherName\": \"{$d->fatherName}\",
                            \"pep\": {$d->pep}
                            },
                            \"document\": {
                            \"type\": \"{$d->document_type}\",
                            \"number\": \"".numero($d->document_number)."\",
                            \"issuingState\": \"{$d->document_issuingState}\",
                            \"issuingAuthority\": \"{$d->document_issuingAuthority}\",
                            \"issueDate\": \"{$d->document_issueDate}\"
                            },
                            \"address\": {
                            \"zipCode\": \"".numero($d->address_zipCode)."\",
                            \"street\": \"{$d->address_street}\",
                            \"number\": \"{$d->address_number}\",
                            \"complement\": null,
                            \"neighborhood\": \"{$d->address_neighborhood}\",
                            \"city\": \"{$d->address_city}\",
                            \"state\": \"{$d->address_state}\"
                            },
                            \"disbursementBankAccount\": {
                            \"bankCode\": \"".numero($d->bankCode)."\",
                            \"accountType\": \"".numero($d->accountType)."\",
                            \"accountNumber\": \"".numero($d->accountNumber)."\",
                            \"accountDigit\": \"".numero($d->accountDigit)."\",
                            \"branchNumber\": \"".numero($d->branchNumber)."\"
                            }
                        }"
        ]);

        $query = "update consultas set 
                    proposta = '{$proposta}'
                    where codigo = '{$_POST['proposta']}'
                ";
        mysqli_query($con, $query);

    }


    $query = "select * from clientes where codigo = '{$_SESSION['codUsr']}'";
    $result = mysqli_query($con, $query);
    $cliente = mysqli_fetch_object($result);

?>
<style>
    .card{
        border-color:#534ab3,
    }
    .card-header{
        background-color:#534ab3;
        color:#fff;
    }
    .card-title{
        font-weight:bold;
        color:#534ab3;
    }
    .card-text{
        color:#534ab3;
    }
</style>
<div class="card m-3">
  <h5 class="card-header">Antecipação - FGTS</h5>
  <div class="card-body">
    <h5 class="card-title">
        <div class="d-flex justify-content-between">
            <span>Simulações /Propostas</span>
            <button class="btn btn-success btn-sm" simulacao>Verificar Saldo</button>
        </div>
    </h5>
    <div class="card-text" style="min-height:400px;">

    <?php

    $query = "select *, dados->>'$.statusCode' as simulacao, proposta->>'$.statusCode' as status_proposta from consultas where cliente = '{$_SESSSION['codUsr']}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        $dados = json_decode($d->dados);

        $q = "select * from configuracoes where codigo = '1'";
        $r = mysqli_query($con, $q);
        $t = mysqli_fetch_object($r);
        $tab = json_decode($t->api_vctex_tabelas);
        foreach($tab->data as $i => $v){
            if($v->id == $d->tabela_escolhida) $tabela_sugerida = $v->name;
            if($v->id == $d->tabela) $tabela_resultado = $v->name;
        }

        if($dados->statusCode == 200 and $dados->data->simulationData->installments){
    ?>
        <div class="card mb-3 border-<?=(($d->status_proposta and $d->status_proposta < 400)?'success':'primary')?>">
            <div class="card-header bg-<?=(($d->status_proposta and $d->status_proposta < 400)?'success':'primary')?> text-white">
            <?=(($d->status_proposta and $d->status_proposta < 400)?'PROPOSTA':'SIMULAÇÃO')?> - <?=strtoupper($d->consulta)?>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th colspan="4">Tabela Sugerida</th>
                        <th colspan="4">Resultado da Tabela</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><?=$tabela_sugerida?></td>
                        <td colspan="4"><?=$tabela_resultado?></td>
                    </tr>
                </tbody>    
                <thead>
                    <tr>
                        <th colspan="7">Período</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($dados->data->simulationData->installments as $periodo => $valor){
                    ?>
                    <tr>
                        <td colspan="7"><?=dataBr($valor->dueDate)?></td>
                        <td>R$ <?=number_format($valor->amount,2,',','.')?></td>
                    </tr>
                    <?php                       
                    }
                    ?>
                </tbody>
                <thead>
                    <tr>
                        <th>Data operação</th>
                        <th>IOF</th>
                        <th>Liberado</th>
                        <th>Emissão</th>
                        <th>TAC</th>
                        <th>CET anual</th>
                        <th>Taxa anual</th>
                        <th>Mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=dataBR($d->data)?></td>
                        <td><?=$dados->data->simulationData->iofAmount?></td>
                        <td><?=$dados->data->simulationData->totalReleasedAmount?></td>
                        <td><?=$dados->data->simulationData->totalAmount?></td>
                        <td><?=$dados->data->simulationData->contractTACAmount?></td>
                        <td><?=$dados->data->simulationData->contractCETRate?></td>
                        <td><?=$dados->data->simulationData->contractRate?></td>
                        <td><?=$dados->data->simulationData->minDisbursedAmount?></td>
                    </tr>
                </tbody>    
            </table>
            
            <?php
                if(!$d->status_proposta or $d->status_proposta >= 400){
            ?>
            <button proposta="<?=$d->codigo?>" class="btn btn-warning btn-sm m-3">
                Solicitar proposta para esta simulação
            </button>
            <?php
                if($d->status_proposta){
                    $proposta = json_decode($d->proposta);
            ?>
                <div class="alert alert-danger m-3" role="alert">
                    <?="{$proposta->statusCode} - {$proposta->message}"?>
                </div>
            <?php
                }

                }else{

                    $proposta = json_decode($d->proposta);
            ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th colspan="4">Número do Contrato</th>
                        <th colspan="4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><?=$proposta->data->proposalcontractNumber?></td>
                        <td colspan="4"><?="{$proposta->statusCode} - {$proposta->message}"?></td>
                    </tr>
                </tbody> 
            </table>
            <div class="row">
                <div class="col">
                    <div class="m-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
                            <div class="form-control"><?=$proposta->data->formalizationLink?></div>
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar o link" copiar="<?=$proposta->data->formalizationLink?>"><i class="fa-solid fa-copy"></i></button>
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="tooltip" data-bs-placement="top" title="Enviar link por whatsApp" wapp="<?=$d->codigo?>" disabled><i class="fa-brands fa-whatsapp"></i></button>
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="tooltip" data-bs-placement="top" title="Enviar link por SMS" sms="<?=$d->codigo?>" disabled><i class="fa-solid fa-comment-sms"></i></button>
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="tooltip" data-bs-placement="top" title="Enviar link por e-mail" email="<?=$d->codigo?>" disabled><i class="fa-solid fa-at"></i></button>
                            <button class="btn btn-outline-secondary" type="button" id="button-addon1" data-bs-toggle="tooltip" data-bs-placement="top" title="Atualizar Status da proposta" proposalId="<?=$proposta->data->proposalId?>" atualiza_proposta="<?=$d->codigo?>"><i class="fa-solid fa-rotate"></i></button>
                        </div>           
                    </div>         
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    <?php
        }else{
    ?>
    <div class="card mb-3 border-danger">
        <div class="card-header bg-danger text-white">
        SIMULAÇÃO - <?=strtoupper($d->consulta)?>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Data operação</th>
                    <th>Erro</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=dataBR($d->data)?></td>
                    <td><?=$dados->statusCode?></td>
                    <td><?=$dados->message?></td>
                </tr>
            </tbody>    
        </table>
    </div>
    <?php
        }
    }
    ?>
    </div>
  </div>
  <button class="btn btn-primary btn-sm atualiza">Atualizar</button>
</div>


<script>
    $(function(){

        $(".atualiza").click(function(){
            $.ajax({
                url:"fgts/consulta.php",
                success:function(dados){
                    $(".palco").html(dados);
                }
            })
        })

        // Carregando('none');

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $("button[copiar]").click(function(){
            obj = $(this);
            texto = $(this).attr("copiar");
            CopyMemory(texto);
            obj.removeClass('btn-outline-secondary');
            obj.addClass('btn-outline-success');
        });
      

        $("button[atualiza_proposta]").click(function(){

            proposalId = $(this).attr("proposalId");
            atualiza_proposta = $(this).attr("atualiza_proposta");

            // Carregando();

            $.ajax({
                url:"fgts/consulta.php",
                type:"POST",
                data:{
                    acao:'atualiza_proposta',
                    proposalId,
                    atualiza_proposta
                },
                success:function(dados){
                    $(".palco").html(dados);
                }
            })            
            

        })     

        $("button[simulacao]").click(function(){

            $.confirm({
                title:"Simulação",
                content:"Confirma a solicitação para simulação?",
                type:"orange",
                buttons:{
                    'sim':{
                        text:'Sim',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){
                            // Carregando();

                            $.ajax({
                                url:"fgts/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'simulacao'
                                },
                                success:function(dados){
                                    $(".palco").html(dados);
                                },
                                error:function(){
                                    alert('Erro')
                                }
                            })  
                        }
                    },
                    'nao':{
                        text:'Não',
                        btnClass:'btn btn-danger btn-sm',
                        action:function(){
                            
                        }
                    }
                }
            })

        })  


        $("button[proposta]").click(function(){

            proposta = $(this).attr("proposta");

            $.confirm({
                title:"Proposta",
                content:"Confirma a solicitação de proposta?",
                type:"orange",
                buttons:{
                    'sim':{
                        text:'Sim',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){
                            // Carregando();

                            $.ajax({
                                url:"fgts/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'proposta',
                                    proposta
                                },
                                success:function(dados){
                                    $(".palco").html(dados);
                                },
                                error:function(){
                                    alert('Erro')
                                }
                            })  
                        }
                    },
                    'nao':{
                        text:'Não',
                        btnClass:'btn btn-danger btn-sm',
                        action:function(){
                            
                        }
                    }
                }
            })

        })  


    })
</script>