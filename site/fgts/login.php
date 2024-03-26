<?php

include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

function EnviarWapp($n, $m){
    $postdata = http_build_query(
            array(
                    'numero' => $n, // Receivers phonei
                    'mensagem' => $m,
                    //'cnf' => ['instancia' => 'bk', 'template' => 'start_template_1_ice75ebh', 'namespace' => '893ce1ab_31f5_478d_87e1_b257eb83813e', 'language' => 'en'],
              )
            );
    $opts = array('http' =>
            array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
            )
    );
    $context = stream_context_create($opts);
    //$result = file_get_contents('http://wapp.mohatron.com/', false, $context);
    $result = file_get_contents('http://wapp.mohatron.com/', false, $context);
}


if($_POST['telefone']){

    $telefone = str_replace(['-',' ','(',')'],false,trim($_POST['telefone']));
    if(strlen($telefone) != 11){
        echo "{\"status\":\"error\", \"codigo\":\"\"}";
        exit();
    }

    $d1 = rand(1,9);
    $d2 = rand(0,9);
    $d3 = rand(0,9);
    $d4 = rand(0,9);

    $cod = $d1.$d2.$d3.$d4;

    $result = EnviarWapp($_POST['telefone'],"Capital Soluções informe: Seu código de acesso é *{$cod}*");

    echo "{\"status\":\"success\", \"codigo\":\"{$cod}\"}";

    exit();
}
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

<div class="card" data-aos="zoom-in" data-aos-delay="200">
    <div class="card-header">
        Pré-Cadastro
    </div>
    <div class="card-body">
        <h5 class="card-title">Faça a sua identificação</h5>
        <p class="card-text">Digite o seu telefone de contato para receber as credencias de acesso</p>
        
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-mobile-screen-button"></i></span>
            <input type="text" id="telefone" class="form-control" inputmode="numeric" placeholder="Digite seu telefone" aria-label="Telefone" aria-describedby="addon-wrapping" >
            <button class="btn btn-outline-secondary enviar" type="button" id="button-addon1">Enviar</button>
        </div>
        <p style="color:#534ab3; font-size:12px">Enviaremos um SMS ou WhatsApp com código de confirmação do seu do seu acesso.</p>

    </div>
    </div>
</div>

<script>
    $(function(){
        $("#telefone").mask("(99) 99999-9999");

        $(".enviar").click(function(){
            telefone = $("#telefone").val();
            if(!telefone){
                $.alert({
                    type:"red",
                    title:"Erro der Identificação",
                    content: 'Favor Digite o número de seu telefone!'
                })

                return false;
            }

            if($("#telefone").val().length != 15){
                $.alert({
                    type:"red",
                    title:"Erro der Identificação",
                    content: 'O telefone informado não está correto!'
                })

                return false;                
            }

            $.ajax({
                url:"fgts/login.php",
                dataType:"JSON",
                data:{
                    telefone
                },
                type:"POST",
                success:function(dados){
                    codigo = dados.codigo
                    if(codigo){
                        localStorage.setItem("codUsr", codigo);
                        $.ajax({
                            url:"fgts/confirma_acesso.php",
                            type:"POST",
                            data:{
                                codigo,
                                telefone
                            },
                            success:function(dados){
                                $(".palco").html(dados);
                            }
                        })
                    }else{
                        $.alert({
                            title:"Erro na identificação",
                            content:"O número do telefone está incorreto ou validação indisponível.",
                            type:"red"
                        })
                    }
                }
            });


        })



    })
</script>