<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function numero($v){
        $remove = [" ","/","-",".","(",")"];
        return str_replace($remove, false, $v);
    }

    $facta = new facta;

    $query = "select *, api_facta_dados->>'$.token' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $token = $d->token;

    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $facta->Token();
        $dados = json_decode($retorno);
        if($dados->erro == false){
            $token = $dados->token;
            mysqli_query($con, "update configuracoes set api_facta_expira = '".($agora + 7200)."', api_facta_dados = '{$retorno}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }

    if($_POST['acao'] == 'limpar'){
        $_SESSION['facta_campo'] = false;
        $_SESSION['facta_rotulo'] = false;
        $_SESSION['facta_valor'] = false;
    }


    if($_POST['acao'] == 'consulta'){
        $_SESSION['facta_campo'] = $_POST['campo'];
        $_SESSION['facta_rotulo'] = $_POST['rotulo'];
        $_SESSION['facta_valor'] = $_POST['valor'];
    }


    //consulta do saldo
    if($_POST['acao'] == 'saldo'){
        $_SESSION['facta_campo'] = $_POST['campo'];
        $_SESSION['facta_rotulo'] = $_POST['rotulo'];
        $_SESSION['facta_valor'] = $_POST['valor'];

        $query = "select * from clientes where codigo = '{$_POST['cliente']}'";
        $result = mysqli_query($con, $query);
        $cliente = mysqli_fetch_object($result);
        $retorno = $facta->Saldo([
            'token'=>$token,
            'cpf' => numero($cliente->cpf)
        ]);

        $query = "insert into consultas_facta set 
                                                    consulta = '{$consulta}',
                                                    operadora = 'FACTA',
                                                    cliente = '{$cliente->codigo}',
                                                    data = NOW(),
                                                    tabela_escolhida = '{$_POST['tabela']}',
                                                    tabela = '{$_POST['tabela']}',
                                                    saldo = '{$retorno}'
                                                    
                ";
        mysqli_query($con, $query);

    }    


    if($_SESSION['facta_campo'] and $_SESSION['facta_valor']){
        $query = "select * from clientes where {$_SESSION['facta_campo']} like '%{$_SESSION['facta_valor']}%'";
        $result = mysqli_query($con, $query);
        $cliente = mysqli_fetch_object($result);
    }

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - facta</h5>
  <div class="card-body">
    <h5 class="card-title">Consultas / Simulações /Propostas</h5>
    <div class="card-text" style="min-height:400px;">
        
    <div class="input-group mb-3">
        <!-- <button opcao_busca class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?=(($_SESSION['facta_rotulo'])?:'CPF')?></button>
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
            value="<?=$_SESSION['facta_valor']?>"
        >
        <button
            buscar
            type="button" 
            class="btn btn-outline-secondary"
            campo="<?=(($_SESSION['facta_campo'])?:'cpf')?>"
            rotulo="<?=(($_SESSION['facta_rotulo'])?:'CPF')?>"    
        >Buscar</button>
        <button
            limpar
            type="button" 
            class="btn btn-outline-danger"   
        >Limpar</button>
        <button
            clientes
            type="button" 
            class="btn btn-outline-primary"   
        ><i class="fa-solid fa-users"></i> Clientes</button>
    </div>

    <?php
    if($_SESSION['facta_campo'] and $_SESSION['facta_valor'] and !$cliente->codigo){
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
                $t = json_decode($tab->api_facta_tabelas);
                foreach($t->data as $i => $v){
            ?>
            <option value="<?=$v->id?>" <?=(($tab->api_facta_tabela_padrao == $v->id)?'selected':false)?>><?=$v->name?></option>
            <?php
                }
            ?>
        </select>
        <button saldo class="btn btn-outline-secondary" type="button" id="button-addon1">Verificar Saldo</button>
    </div>
    <?php
    }
    
    $query = "select * from consultas_facta where cliente = '{$cliente->codigo}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        $saldo = json_decode($d->saldo);
        if($saldo->erro == true){
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
            </tr>
            <tr>
                <th>Mensagem</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$saldo->codigo?></td>
            </tr>
            <tr>
                <td><?=$saldo->msg?></td>
            </tr>
        </tbody>
    </table>
    <?php
        }else{
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Período</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for($i = 1; $i <= 12; $i++){
                eval("\$valor = \$saldo->retorno->valor_{$i};");
                eval("\$periodo = \$saldo->retorno->dataRepasse_{$i};");
                if($periodo){
            ?>
            <tr>
                <td><?=$periodo?></td>
                <td><?=$valor?></td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <thead>
            <tr>
                <th>Data Consulta do Saldo</th>
                <th>Saldo Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?="{$saldo->retorno->data_saldo} {$saldo->retorno->horaSaldo}"?></td>
                <td><?="{$saldo->retorno->saldo_total}"?></td>
            </tr>
        </tbody>
    </table>
    <?php
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
            // obj.children("span").text("Código PIX Copiado!");
        });

        $("button[clientes]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/clientes/index.php",
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            });
        });

        $("button[novo]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/clientes/form.php",
                type:"POST",
                data:{
                    cpf:'<?=$_SESSION['facta_valor']?>',
                    retorno:"financeira/facta/consulta.php"
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            });
        });

        $("input[busca]").mask("999.999.999-99");

        $("button[atualiza]").click(function(){
            Carregando();
            $.ajax({
                url:"financeira/facta/consulta.php",
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
                url:"financeira/facta/consulta.php",
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
                url:"financeira/facta/consulta.php",
                type:"POST",
                data:{
                    acao:'limpar'
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })            
            

        })     

        $("button[atualiza_proposta]").click(function(){

            proposalId = $(this).attr("proposalId");
            atualiza_proposta = $(this).attr("atualiza_proposta");

            Carregando();

            $.ajax({
                url:"financeira/facta/consulta.php",
                type:"POST",
                data:{
                    acao:'atualiza_proposta',
                    campo:'<?=$_SESSION['facta_campo']?>',
                    rotulo:'<?=$_SESSION['facta_rotulo']?>',
                    valor:'<?=$_SESSION['facta_valor']?>',
                    proposalId,
                    atualiza_proposta
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })            
            

        })     

        $("button[saldo]").click(function(){

            tabela = $("#tabela").val();

            $.confirm({
                title:"Saldo",
                content:"Confirma a consulta do Saldo?",
                type:"orange",
                buttons:{
                    'sim':{
                        text:'Sim',
                        btnClass:'btn btn-success btn-sm',
                        action:function(){
                            Carregando();

                            $.ajax({
                                url:"financeira/facta/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'saldo',
                                    campo:'<?=$_SESSION['facta_campo']?>',
                                    rotulo:'<?=$_SESSION['facta_rotulo']?>',
                                    valor:'<?=$_SESSION['facta_valor']?>',
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
                                url:"financeira/facta/consulta.php",
                                type:"POST",
                                data:{
                                    acao:'proposta',
                                    campo:'<?=$_SESSION['facta_campo']?>',
                                    rotulo:'<?=$_SESSION['facta_rotulo']?>',
                                    valor:'<?=$_SESSION['facta_valor']?>',
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