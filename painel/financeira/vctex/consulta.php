<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $vctex = new Vctex;

    $query = "select *, api_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
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
        $query = "select * from clientes where {$_POST['campo']} like '%${$_POST['valor']}%'";
        $result = mysqli_query($con, $query);
        $cliente = mysqli_fetch_object($result);
        $_SESSION['vctex_campo'] = $_POST['campo'];
        $_SESSION['vctex_rotulo'] = $_POST['rotulo'];
        $_SESSION['vctex_valor'] = $_POST['valor'];
    }


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
                    <button novo type="button" class="btn btn-outline-primary btn-sm mt-3"><i class="fa-regular fa-user"></i> Cadastrar um novo cliente</button>
                </div>
            </div>
        </div>
    </div>
    <?php
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


    })
</script>