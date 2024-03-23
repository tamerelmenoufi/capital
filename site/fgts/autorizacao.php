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

    $query = "update clientes set {$_POST['campo']} = '{$_POST['valor']}' where codigo = '{$_SESSION['codUsr']}'";
    mysqli_query($con, $query);
    echo 'success';
    exit();

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
        Autorização para FGTS
    </div>
    <div class="card-body">
        <h5 class="card-title">Tela de Autorização</h5>
        <p class="card-text">Antes de fazer a suas simulações e contratação de antecipação do FGTS, é necessário que autorize os bancos parceiros que possibilitam o acessos do seu saldo na CAIXA.</p>
        <p class="card-text">Preparamos um passo a passo pra você seguir e realizar a autorização de forma simples e prática.</p>
        
        <img src="fgts/img/passo_a_passo.png" class="img-fluid" alt="Passo a Passo">

        <div class="mt-2">
            <button class="btn btn-primary btn-sm" local="fgts/cadastro.php"><i class="fa-solid fa-angles-right"></i> Realizar o Cadastro Completo</button>
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

            $.ajax({
                url,
                success:function(dados){
                    $(".palco").html(dados);
                }
            })

        })



    })
</script>