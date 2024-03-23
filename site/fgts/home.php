<?php

include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

if($_POST['acao'] == 'salvar'){

    $query = "update clientes set {$_POST['campo']} = '{$_POST['valor']}' where codigo = '{$_SESSIO['codUsr']}'";
    mysqli_query($con, $query);
    exit();
    
}

if($_POST['telefone']){

    $query = "select * from clientes where phoneNumber = '{$_POST['telefone']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    if(!$d->codigo){
        $query = "insert into clientes set phoneNumber = '{$_POST['telefone']}', data_cadastro = NOW(), validar_telefone = '1'";
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
            <input acao type="text" class="form-control" id="nome" aria-describedby="nome">
            <div id="nome" class="form-text">Digite seu nome completo conforme seu documento de identificação</div>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Número CPF</label>
            <input acao type="text" class="form-control" id="cpf" aria-describedby="cpf">
            <div id="cpf" class="form-text">Digite seu CPF confira o número antes de confirmar</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone de Contato</label>
            <div class="form-control"><?=$d->phoneNumber?></div>
            <div class="form-text">Telefone confirmado no login</div>
        </div>


        <button class="btn btn-danger btn-sm sair"><i class="fa-solid fa-right-from-bracket"></i> Sair do login</button>

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
            $.ajax({
                url:"fgts/home.php",
                type:"POST",
                data:{
                    campo,
                    valor,
                    acao:'salvar'
                },
                success:function(dados){

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



    })
</script>