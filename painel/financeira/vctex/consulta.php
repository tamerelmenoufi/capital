<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function numero($v){
        $remove = [" ","/","-",".","(",")"];
        return str_replace($remove, false, $v);
    }

    $vctex = new Vctex;

    $query = "select *, api_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $token = $d->token;

    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
            $token = $dados->token->accessToken;
            mysqli_query($con, "update configuracoes set api_expira = '".($agora + $dados->token->expires)."', api_dados = '{$retorno}', api_tabelas = '{$tabelas}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }

    if($_POST['acao'] == 'limpar'){
        $_SESSION['vctex_campo'] = false;
        $_SESSION['vctex_rotulo'] = false;
        $_SESSION['vctex_valor'] = false;
    }

    if($_POST['acao'] == 'consulta'){
        $_SESSION['vctex_campo'] = $_POST['campo'];
        $_SESSION['vctex_rotulo'] = $_POST['rotulo'];
        $_SESSION['vctex_valor'] = $_POST['valor'];
    }

    if($_POST['acao'] == 'simulacao'){

        $_SESSION['vctex_campo'] = $_POST['campo'];
        $_SESSION['vctex_rotulo'] = $_POST['rotulo'];
        $_SESSION['vctex_valor'] = $_POST['valor'];


        $query = "select * from clientes where codigo = '{$_POST['cliente']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        $simulacao = $vctex->Simular([
            'token' => $token,
            'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
            'tabela' => $_POST['tabela']
        ]);
        
        $verifica = json_decode($simulacao);
        if($verifica->data->isExponentialFeeScheduleAvailable == true){

            $simulacao = $vctex->Simular([
                'token' => $token,
                'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
                'tabela' => 0
            ]);

            $d->tabela_padrao = 0;

        }


        $consulta = uniqid();


        $query = "insert into consultas set 
                                            consulta = '{$consulta}',
                                            operadora = 'VCTEX',
                                            cliente = '{$_POST['cliente']}',
                                            data = NOW(),
                                            tabela = '{$d->tabela_padrao}',
                                            dados = '{$simulacao}'
                                            ";
        mysqli_query($con, $query);
        // exit();

    }

    if($_POST['acao'] == 'proposta'){

        $_SESSION['vctex_campo'] = $_POST['campo'];
        $_SESSION['vctex_rotulo'] = $_POST['rotulo'];
        $_SESSION['vctex_valor'] = $_POST['valor'];

        $query = "select 
                        b.*,
                        a.tabela,
                        a.dados->>'$.data.financialId' as financialId
                    from consultas a
                         left join clientes b on a.cliente = b.codigo
                    where a.codigo = '{$_POST['proposta']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);


        // echo "{
        //     \"feeScheduleId\": {$d->tabela},
        //     \"financialId\": \"{$d->financialId}\",
        //     \"borrower\": {
        //     \"name\": \"{$d->nome}\",
        //     \"cpf\": \"".numero($d->cpf)."\",
        //     \"birthdate\": \"{$d->birthdate}\",
        //     \"gender\": \"{$d->gender}\",
        //     \"phoneNumber\": \"".numero($d->phoneNumber)."\",
        //     \"email\": \"{$d->email}\",
        //     \"maritalStatus\": \"{$d->maritalStatus}\",
        //     \"nationality\": \"{$d->nationality}\",
        //     \"naturalness\": \"{$d->naturalness}\",
        //     \"motherName\": \"{$d->motherName}\",
        //     \"fatherName\": \"{$d->fatherName}\",
        //     \"pep\": {$d->pep}
        //     },
        //     \"document\": {
        //     \"type\": \"{$d->document_type}\",
        //     \"number\": \"".numero($d->document_number)."\",
        //     \"issuingState\": \"{$d->document_issuingState}\",
        //     \"issuingAuthority\": \"{$d->document_issuingAuthority}\",
        //     \"issueDate\": \"{$d->document_issueDate}\"
        //     },
        //     \"address\": {
        //     \"zipCode\": \"".numero($d->address_zipCode)."\",
        //     \"street\": \"{$d->address_street}\",
        //     \"number\": \"{$d->address_number}\",
        //     \"complement\": null,
        //     \"neighborhood\": \"{$d->address_neighborhood}\",
        //     \"city\": \"{$d->address_city}\",
        //     \"state\": \"{$d->address_state}\"
        //     },
        //     \"disbursementBankAccount\": {
        //     \"bankCode\": \"".numero($d->bankCode)."\",
        //     \"accountType\": \"".numero($d->accountType)."\",
        //     \"accountNumber\": \"".numero($d->accountNumber)."\",
        //     \"accountDigit\": \"".numero($d->accountDigit)."\",
        //     \"branchNumber\": \"".numero($d->branchNumber)."\"
        //     }
        // }";

            // cpf,phoneNumber,document_number, zipCode, bankCode, accountNumber, accountDigit, branchNumber
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


    if($_SESSION['vctex_campo'] and $_SESSION['vctex_valor']){
        echo $query = "select * from clientes where {$_SESSION['vctex_campo']} like '%{$_SESSION['vctex_valor']}%'";
        $result = mysqli_query($con, $query);
        $cliente = mysqli_fetch_object($result);
    }

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - VCTEX</h5>
  <div class="card-body">
    <h5 class="card-title">Consultas / Simulações /Propostas</h5>
    <div class="card-text" style="min-height:400px;">
        
    <div class="input-group mb-3">
        <!-- <button opcao_busca class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?=(($_SESSION['vctex_rotulo'])?:'CPF')?></button>
        <ul class="dropdown-menu">
            <li><a selecione="cpf" class="dropdown-item" href="#">CPF</a></li>
            <li><a selecione="nome" class="dropdown-item" href="#">Nome</a></li>
        </ul> -->
        <span class="input-group-text">CPF</span>
        <input 
            type="text" 
            class="form-control" 
            aria-label="Text input with dropdown button"
            busca
            value="<?=$_SESSION['vctex_valor']?>"
        >
        <button
            buscar
            type="button" 
            class="btn btn-outline-secondary"
            campo="<?=(($_SESSION['vctex_campo'])?:'cpf')?>"
            rotulo="<?=(($_SESSION['vctex_rotulo'])?:'CPF')?>"    
        >Buscar</button>
        <button
            limpar
            type="button" 
            class="btn btn-outline-danger"   
        >Limpar</button>
    </div>

    <?php
    echo $q;
    if($_POST['acao'] == 'consulta' and !$cliente->codigo){
    ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-secondary" role="alert">
                <div class="d-flex flex-column justify-content-center align-items-center" style="height:300px;">
                    <h1 class="text-color-secondary">Busca sem resultados <i class="fa-regular fa-face-frown-open"></i></h1>
                    <button 
                        novo
                        type="button"
                        class="btn btn-outline-primary btn-sm mt-3"
                        data-bs-toggle="offcanvas"
                        href="#offcanvasDireita"
                        role="button"
                        aria-controls="offcanvasDireita"
                    ><i class="fa-regular fa-user"></i> Cadastrar um novo cliente</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    }else if($cliente->codigo){
    ?>
    <div class="input-group mb-3">
        <span class="input-group-text"><?=$cliente->nome?></span>
        <span class="input-group-text"><?=$cliente->cpf?></span>
        <select id="tabela" class="form-select">
            <?php
                $q = "select * from configuracoes where codigo = '1'";
                $r = mysqli_query($con, $q);
                $tab = mysqli_fetch_object($r);
                $t = json_decode($tab->api_tabelas);
                foreach($t->data as $i => $v){
            ?>
            <option value="<?=$v->id?>" <?=(($tab->api_tabela_padrao == $v->id)?'selected':false)?>><?=$v->name?></option>
            <?php
                }
            ?>
        </select>
        <button simulacao class="btn btn-outline-secondary" type="button" id="button-addon1">Criar uma Simulação</button>
    </div>
    <?php

    $query = "select *, dados->>'$.statusCode' as simulacao, proposta->>'$.statusCode' as status_proposta from consultas where cliente = '{$cliente->codigo}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        $dados = json_decode($d->dados);
        if($dados->statusCode == 200){
    ?>
        <div class="card mb-3 border-primary">
            <div class="card-header bg-primary text-white">
            <?=(($d->proposta == 200)?'PROPOSTA':'SIMULAÇÃO')?> - <?=strtoupper($d->consulta)?>
            </div>
            <table class="table table-hover table-striped">
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
                if($dados->data->isExponentialFeeScheduleAvailable){
            ?>
            <div class="alert alert-success p-1 m-2" role="alert">
                A simulação apresenta uma tabela <b><?=$dados->data->isVendexFeeScheduleAvailable?></b> mais vantajoso.
            </div>
            <?php
                }
                if($d->status_proposta != 200){
            ?>
            <button proposta="<?=$d->codigo?>" class="btn btn-warning btn-sm">
                Solicitar proposta para esta simulação
            </button>
            <?php
                }
                    var_dump($d->proposta);
                

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
    }
    ?>
    </div>
    <button atualiza class="btn btn-primary">Atualizar</button>
  </div>
</div>


<script>
    $(function(){

        Carregando('none');

        $("input[busca]").mask("999.999.999-99");

        $("button[atualiza]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/vctex/consulta.php",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })

        // $("a[selecione]").click(function(){
        //     campo = $(this).attr("selecione");
        //     rotulo = $(this).text();
        //     $("button[buscar]").attr("campo", campo);
        //     $("button[buscar]").attr("rotulo", rotulo);
        //     $("button[opcao_busca]").text(rotulo);
        //     if(campo == 'cpf'){
        //         $("input[busca]").mask("999.999.999-99");
        //     }else{
        //         $("input[busca]").unmask();
        //     }
        //     $("input[busca]").val('');
        // })

        $("button[buscar]").click(function(){
            

            campo = $(this).attr("campo");
            rotulo = $(this).attr("rotulo");
            valor = $("input[busca]").val();
            console.log(`Buscar: ${valor} em ${campo}`);
            if(campo == 'cpf'){
                if(!validarCPF(valor)){
                    $.alert({
                        content:"CPF inválido!",
                        title:"Erro",
                        type:'red'
                    });
                    return false;
                }
            }
            Carregando();
            $.ajax({
                url:"financeira/vctex/consulta.php",
                type:"POST",
                data:{
                    campo,
                    rotulo,
                    valor,
                    acao:'consulta'
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })            
            

        })     
        
        $("button[limpar]").click(function(){
            Carregando();

            $.ajax({
                url:"financeira/vctex/consulta.php",
                type:"POST",
                data:{
                    acao:'limpar'
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })            
            

        })     

        $("button[simulacao]").click(function(){

            tabela = $("#tabela").val();

            $.confirm({
                title:"Simulação",
                content:"Confirma a solicitação para simulação?",
                type:"orange",
                buttons:{
                    'sim':{
                        text:'Sim',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){
                            Carregando();

                            $.ajax({
                                url:"financeira/vctex/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'simulacao',
                                    campo:'<?=$_SESSION['vctex_campo']?>',
                                    rotulo:'<?=$_SESSION['vctex_rotulo']?>',
                                    valor:'<?=$_SESSION['vctex_valor']?>',
                                    cliente:'<?=$cliente->codigo?>',
                                    tabela
                                },
                                success:function(dados){
                                    $("#paginaHome").html(dados);
                                    // console.log(dados);
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
                            Carregando();

                            $.ajax({
                                url:"financeira/vctex/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'proposta',
                                    campo:'<?=$_SESSION['vctex_campo']?>',
                                    rotulo:'<?=$_SESSION['vctex_rotulo']?>',
                                    valor:'<?=$_SESSION['vctex_valor']?>',
                                    proposta
                                },
                                success:function(dados){
                                    $("#paginaHome").html(dados);
                                    // console.log(dados);
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