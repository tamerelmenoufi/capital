<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

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


        $query = "select *, (select api_tabela_padrao from configuracoes where codigo = '1') as tabela_padrao from clientes where codigo = '{$_POST['cliente']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        $simulacao = $vctex->Simular([
            'token' => $token,
            'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
            'tabela' => $d->tabela_padrao
        ]);
        // print_r([
        //     'token' => $token,
        //     'cliente' => str_replace(['-',' ','.'],false,trim($d->cpf)),
        //     'tabela' => $d->tabela_padrao
        // ]);
        $consulta = uniqid();


        $query = "insert into consultas set 
                                            consulta = '{$consulta}',
                                            operadora = 'VCTEX',
                                            cliente = '{$_POST['cliente']}',
                                            data = NOW(),
                                            tipo = 'simulacao',
                                            dados = '{$simulacao}'
                                            ";
        mysqli_query($con, $query);
        // exit();

    }



    $query = "select * from clientes where {$_SESSION['vctex_campo']} like '%${$_SESSION['vctex_valor']}%'";
    $result = mysqli_query($con, $query);
    $cliente = mysqli_fetch_object($result);

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - VCTEX</h5>
  <div class="card-body">
    <h5 class="card-title">Consultas / Simulações /Propostas</h5>
    <div class="card-text" style="min-height:400px;">
        
    <div class="input-group mb-3">
        <button opcao_busca class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?=(($_SESSION['vctex_rotulo'])?:'CPF')?></button>
        <ul class="dropdown-menu">
            <li><a selecione="cpf" class="dropdown-item" href="#">CPF</a></li>
            <li><a selecione="nome" class="dropdown-item" href="#">Nome</a></li>
        </ul>
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
    </div>

    <?php
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
        <button simulacao class="btn btn-outline-secondary" type="button" id="button-addon1">Criar uma Simulação</button>
    </div>
    <?php

    $query = "select * from consultas where cliente = '{$cliente->codigo}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        $dados = json_decode($d->dados);
        if($dados->statusCode == 200){
    ?>
        <div class="card mb-3 border-primary">
            <div class="card-header bg-primary text-white">
            Simulação - <?=strtoupper($d->consulta)?>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th colspan="6">Período</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($dados->data->simulationData->installments as $periodo => $valor){
                    ?>
                    <tr>
                        <td colspan="6"><?=dataBr($valor->dueDate)?></td>
                        <td>R$ <?=number_format($valor->amount,2,',','.')?></td>
                    </tr>
                    <?php                       
                    }
                    ?>
                </tbody>
                <thead>
                    <tr>
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
                    // "isVendexFeeScheduleAvailable": false,
                    // "isExponentialFeeScheduleAvailable": false

                if($dados->data->isExponentialFeeScheduleAvailable){
            ?>
            <p>
                A simulação apresenta uma tabela <b><?=$dados->data->financialId?></b> mais vantajoso.
            </p>
            <?php
                }
            ?>
        </div>
    <?php
        }else{
    ?>
    <div class="card mb-3 border-danger">
        <div class="card-header bg-danger text-white">
        Simulação - <?=strtoupper($d->consulta)?>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Erro</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <tr>
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

        <?php
        if($_SESSION['vctex_rotulo'] == 'CPF'){
        ?>
        $("input[busca]").mask("999.999.999-99");
        <?php
        }
        ?>
        $("button[atualiza]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/vctex/consulta.php",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })

        $("a[selecione]").click(function(){
            campo = $(this).attr("selecione");
            rotulo = $(this).text();
            $("button[buscar]").attr("campo", campo);
            $("button[buscar]").attr("rotulo", rotulo);
            $("button[opcao_busca]").text(rotulo);
            if(campo == 'cpf'){
                $("input[busca]").mask("999.999.999-99");
            }else{
                $("input[busca]").unmask();
            }
            $("input[busca]").val('');
        })

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
                                    cliente:'<?=$cliente->codigo?>'
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