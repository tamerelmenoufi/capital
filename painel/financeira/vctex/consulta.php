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


?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira - VCTEX</h5>
  <div class="card-body">
    <h5 class="card-title">Consultas / Simulações /Propostas</h5>
    <p class="card-text">
        
    <div class="input-group mb-3">
        <button opcao_busca class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">CPF</button>
        <ul class="dropdown-menu">
            <li><a selecione="cpf" class="dropdown-item" href="#">CPF</a></li>
            <li><a selecione="nome" class="dropdown-item" href="#">Nome</a></li>
        </ul>
        <input 
            type="text" 
            class="form-control" 
            aria-label="Text input with dropdown button"
            busca
        >
        <button
            buscar
            type="button" 
            class="btn btn-outline-secondary"
            campo="cpf"
            rotulo="CPF"            
        >Buscar</button>
    </div>


    </p>
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
            // Carregando();
            // $.ajax({
            //     url:"financeira/vctex/consulta.php",
            //     success:function(dados){
            //         $("#paginaHome").html(dados);
            //     }
            // })
            campo = $(this).attr("campo");
            valor = $("input[busca]").val();
            console.log(`Buscar: ${valor} em ${campo}`);
            if(campo == 'cpf'){
                if(validarCpf(valor)){
                    console.log(`CPF ${valor} Válido`);
                }else{
                    console.log(`CPF ${valor} Inválido`);

                }
            }
            

        })        


    })
</script>