<?php

include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

if($_POST['acao'] == 'salvar'){

    if($_POST['campo'] == 'cpf'){
        $query = "select * from clientes where cpf = '{$_POST['valor']}' and codigo != '{$_SESSION['codUsr']}'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result)){
            echo 'error';
            exit();
        }
    }
    $valor = addslashes($_POST['valor']);
    $query = "update clientes set {$_POST['campo']} = '{$valor}' where codigo = '{$_SESSION['codUsr']}'";
    mysqli_query($con, $query);
    echo 'success';
    exit();

}

if($_POST['telefone']){

    $query = "select * from clientes where phoneNumber = '{$_POST['telefone']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    if(!$d->codigo){
        $query = "insert into clientes set phoneNumber = '{$_POST['telefone']}', data_cadastro = NOW(), validar_telefone = NOW()";
        $result = mysqli_query($con, $query);
        $_SESSION['codUsr'] = mysqli_insert_id($con); 
    }else{
        $_SESSION['codUsr'] = $d->codigo; 
    }

}


$query = "select * from clientes where codigo = '{$_SESSION['codUsr']}'";
$result = mysqli_query($con, $query);
$d = mysqli_fetch_object($result);

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
        <h5 class="card-title">Tela de Identificação</h5>
        <p class="card-text">Formulário de Pré-Cadastro. Os dados a seguir são obrigatório para confirmação do seu pré-cadastro.</p>
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input acao type="text" class="form-control" id="nome" aria-describedby="nome" value="<?=$d->nome?>">
            <div id="nome" class="form-text">Digite seu nome completo conforme seu documento de identificação</div>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Número CPF</label>
            <input acao type="text" class="form-control" inputmode="numeric" id="cpf" aria-describedby="cpf" value="<?=$d->cpf?>">
            <div id="cpf" class="form-text">Digite seu CPF confira o número antes de confirmar</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone de Contato</label>
            <div class="form-control"><?=$d->phoneNumber?></div>
            <div class="form-text">Telefone confirmado no login</div>
        </div>
        <div class="mt-2">
            <button class="btn btn-primary btn-sm" local="fgts/autorizacao.php"><i class="fa-solid fa-angles-right"></i> Autorizar as Consultas</button>
        </div>

        <div class="mt-3 text-end">
            <a class="text-danger text-decoration-none sair" style="cursor:pointer"><i class="fa-solid fa-right-from-bracket"></i> Sair do login</a>
        </div>

    </div>
    </div>
</div>

<script>
    $(function(){

        $("#cpf").mask("999.999.999-99");

        <?php
        //verificação do pré-cadastro
        if($d->pre_cadastro > 0){
        ?>
            // $(`i[etapa="fgts/home.php"], div[etapa="fgts/home.php"]`).attr("acao", "lib");
            // $(`i[etapa="fgts/autorizacao.php"], div[etapa="fgts/autorizacao.php"]`).attr("acao", "lib");
            // $(".linha").css("width","33%");
            // $(`i[etapa="fgts/autorizacao.php"]`).removeClass("fa-regular");
            // $(`i[etapa="fgts/autorizacao.php"]`).addClass("fa-solid");
            // $(`i[etapa="fgts/home.php"]`).removeClass("fa-regular");
            // $(`i[etapa="fgts/home.php"]`).addClass("fa-solid");
        <?php
        }else{
        ?>
            // $(`i[etapa="fgts/home.php"], div[etapa="fgts/home.php"]`).attr("acao", "blq");
            // $(`i[etapa="fgts/autorizacao.php"], div[etapa="fgts/autorizacao.php"]`).attr("acao", "blq");
            // $(".linha").css("width","0%");
            // $(`i[etapa="fgts/autorizacao.php"]`).removeClass("fa-solid");
            // $(`i[etapa="fgts/autorizacao.php"]`).addClass("fa-regular");
            // $(`i[etapa="fgts/home.php"]`).removeClass("fa-solid");
            // $(`i[etapa="fgts/home.php"]`).addClass("fa-regular");
        <?php
        }

        //verificação da autorização
        if($d->autorizacao_vctex > 0){
        ?>
            // $(`i[etapa="fgts/cadastro.php"], div[etapa="fgts/cadastro.php"]`).attr("acao", "lib");
            // $(".linha").css("width","66%");
            // $(`i[etapa="fgts/cadastro.php"]`).removeClass("fa-regular");
            // $(`i[etapa="fgts/cadastro.php"]`).addClass("fa-solid");
        <?php
        }else{
        ?>
            // $(`i[etapa="fgts/cadastro.php"], div[etapa="fgts/cadastro.php"]`).attr("acao", "blq");
            // $(".linha").css("width","33%");
            // $(`i[etapa="fgts/cadastro.php"]`).removeClass("fa-solid");
            // $(`i[etapa="fgts/cadastro.php"]`).addClass("fa-regular");
        <?php
        }

        //verificação da autorização
        if($d->cadastro_percentual == 100){
        ?>
            // $(`i[etapa="fgts/consulta.php"], div[etapa="fgts/consulta.php"]`).attr("acao", "lib");
            // $(".linha").css("width","100%");
            // $(`i[etapa="fgts/consulta.php"]`).removeClass("fa-regular");
            // $(`i[etapa="fgts/consulta.php"]`).addClass("fa-solid");
        <?php
        }else{
        ?>
            // $(`i[etapa="fgts/consulta.php"], div[etapa="fgts/consulta.php"]`).attr("acao", "blq");
            // $(".linha").css("width","66%");
            // $(`i[etapa="fgts/consulta.php"]`).removeClass("fa-solid");
            // $(`i[etapa="fgts/consulta.php"]`).addlass("fa-regular");
        <?php
        }
        



        if($_SESSION['codUsr']){
        ?>
        localStorage.setItem("codUsr", '<?=$_SESSION['codUsr']?>');
        $.ajax({
            url:"fgts/sessao.php",
            type:"POST",
            data:{
                codUsr:'<?=$_SESSION['codUsr']?>'
            },
            success:function(dados){
                // $(".palco").html(dados);
                console.log(dados)
            }
        })
        <?php
        }
        ?>

        $("input[acao]").blur(function(){
            campo = $(this).attr("id");
            valor = $(this).val();
            if(campo == 'cpf'){

                if(!validarCPF(valor)){
                    $.alert({
                        title:"Erro CPF",
                        content:"O CPF Informado não é válido!",
                        type:'red'
                    })
                    $("#cpf").val('');
                    return false;
                }
            }   


            $.ajax({
                url:"fgts/home.php",
                type:"POST",
                data:{
                    campo,
                    valor,
                    acao:'salvar'
                },
                success:function(dados){
                    
                    if(dados == 'error'){
                        $.alert({
                            title: "Erro CPF",
                            content:"O CPF Informado Já encontra-se cadastrado!",
                            type:'red'
                        })
                        $("#cpf").val('');
                    }
                }
            })
        })

        $(".sair").click(function(){
            telefone = $("#telefone").val();
            
            $.confirm({
                title:"Sair do Login",
                content:'Deseja realmente sair do login da sua área restrita?',
                type:'orange',
                buttons:{
                    'Sim':{
                        text:'SIM',
                        btnClass:'btn btn-danger btn-sm',
                        action:function(){
                            localStorage.removeItem("codUsr");
                            $.ajax({
                                url:"fgts/sessao.php",
                                data:{
                                    codUsr:''
                                },
                                type:"POST",
                                success:function(dados){

                                    $.ajax({
                                        url:"fgts/login.php",
                                        success:function(dados){
                                            $(".palco").html(dados);
                                        }
                                    })

                                }
                            });


                        }
                    },
                    'não':{
                        text:'NÃO',
                        btnClass:'btn btn-primary btn-sm',
                        action:function(){

                        }
                    },
                    
                }
            })

            


        })

        $("button[local]").click(function(){

            url = $(this).attr("local");
            nome = $("#nome").val();
            cpf = $("#cpf").val();

            

            if(!nome || !cpf){
                $.alert({
                    title:'Dados Incompletos',
                    content:"Para prosseguir é necessáro preencher os dados completos do formulário.",
                    type:'red'
                });

                return false;
            }

            $.ajax({
                url,
                success:function(dados){
                    $(".palco").html(dados);
                }
            })

        })



    })
</script>