<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_GET['s']){
        $_SESSION = [];
        header("location:./");
        exit();
    }

    $app = (($_GET['app'])?:'financeira');

    if($_SESSION['ProjectPainel']->perfil == 'adm'){
        $url = "{$app}/home/index.php";
    }else if($_SESSION['ProjectPainel']->perfil == 'financeiro'){
        $url = "financeira/home/index.php";
    }else if($_SESSION['ProjectPainel']->perfil == 'site'){
        $url = "site/home/index.php";
    }else if($_SESSION['ProjectPainel']->perfil == 'consulta'){
        $url = "{$app}/home/index.php";
    }else{
        $url = "src/login/index.php";
    }
?>
<!doctype html>
<html lang="en" translate="no">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="img/icone.png" rel="icon">
    <meta name="google" content="notranslate">
    <title>capitalsolucoes - Painel de controle</title>
    <?php
    include("lib/header.php");
    ?>
  </head>
  <style>
body {

    background: url(img/fundopncred.jpg);
    background-repeat: no-repeat center fixed;
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
.toast-container{
    position:fixed!important;
}

</style>

  <body chatData="<?=date("Y-m-d H:i:s")?>">

    <div class="Carregando">
        <div><i class="fa-solid fa-rotate fa-pulse"></i></div>
    </div>

    <div class="CorpoApp"></div>


    <div class="toast-container bottom-0 end-0 p-3"></div>
    <?php
    include("lib/footer.php");
    ?>

    <script>
        $(function(){

            //conexão websocket
            const ws = new WebSocket("wss://ws.capitalsolucoesam.com.br/");

            ws.addEventListener('message', message => {
                // console.log(message)
                const dados = JSON.parse(message.data);
                dados.forEach(function(d){
                    // console.log(d)
                    if(d.type === 'chat'){
                        // console.log(d.text);
                        if(d.text){
                            

                            layout = '<div class="d-flex flex-row">'+
                            '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#ffffff; border:0; border-radius:10px;">'+
                            '<div class="text-start" style="border:solid 0px red;">'+d.text+'</div>' +
                            '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">'+d.data+'</div>' +
                            '</div>' +
                            '</div>';

                            $(`div[up${d.de}]`).append(layout);

                            altura = $(`div[up${d.de}]`).prop("scrollHeight");
                            div = $(`div[up${d.de}]`).height();
                            $(`div[up${d.de}]`).scrollTop(altura + div);    
                            <?php
                            if($_SESSION['ProjectPainel']->login == 'tamer'){
                            ?>
                            chatAtivo = $(`div[up${d.de}]`).attr("ativo");
                            if(!chatAtivo){
                                alerta = `<div popup${d.de} class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                                <div class="toast-header">
                                                    <img src="img/icone.php" class="rounded me-2" alt="...">
                                                    <strong class="me-auto">${d.de}</strong>
                                                    <small>11 mins ago</small>
                                                    <button close="${d.de}" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                                </div>
                                                <div class="toast-body">
                                                    ${d.text}
                                                </div>
                                            </div>`;
                                $(".toast-container").append(alerta);
                                $(`div[popup${d.de}]`).show();
                                console.log(alerta)
                            }
                            <?php
                            }
                            ?>
                        }
                    }                    
                })

            });
            //websocked


            Carregando();
            $.ajax({
                url:"<?=$url?>",
                success:function(dados){
                    $(".CorpoApp").html(dados);
                }
            });

            setInterval(() => {
                $.ajax({
                    url:"lib/sessao.php",
                    success:function(dados){
                        $("body").attr("sessao",dados);
                    }
                });                
            }, 5000);

            $(docuemnt).off('click').on('click','button[close]', function(){
                janela = $(this).attr("close");
                $(`div[popup${d.de}]`).remove();
            })
        })


        //Jconfirm
        jconfirm.defaults = {
            typeAnimated: true,
            type: "blue",
            smoothContent: true,
        }

    </script>

  </body>
</html>