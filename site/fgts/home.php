<?php

include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

$query = "select * from clientes where codigo = '{$_SESSION['codUsr']}'";

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
        <h5 class="card-title">Identificação do Usuários</h5>
        <p class="card-text">Digite o seu telefone de contato para receber as credencias de acesso</p>
        
        <!-- <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-mobile-screen-button"></i></span>
            <input type="text" id="telefone" class="form-control" inputmode="numeric" placeholder="Digite seu telefone" aria-label="Telefone" aria-describedby="addon-wrapping" >
            <button class="btn btn-outline-secondary enviar" type="button" id="button-addon1">Enviar</button>
        </div>
        <p style="color:#534ab3; font-size:12px">Enviaremos um SMS ou WhatsApp com código de confirmação do seu do seu acesso.</p> -->


        <button class="btn btn-danger btn-sm sair"><i class="fa-solid fa-right-from-bracket"></i> Sair do login</button>

    </div>
    </div>
</div>

<script>
    $(function(){

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
                                        data:{
                                            codigo
                                        },
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