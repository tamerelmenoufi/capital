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

</style>

  <body chatData="<?=date("Y-m-d H:i:s")?>">

    <div class="Carregando">
        <div><i class="fa-solid fa-rotate fa-pulse"></i></div>
    </div>

    <div class="CorpoApp"></div>

    <?php
    include("lib/footer.php");
    ?>

    <script>
        $(function(){

            //conexão websocket
            const ws = new WebSocket("wss://ws.capitalsolucoesam.com.br/");

            ws.addEventListener('message', message => {
                console.log(message)
                const dados = JSON.parse(message.data);
                dados.each(function(d){
                    if(d.type === 'chat'){
                        // console.log(dados.text);
                        if(d.text){
                            mensagem =  `<div style="position:fixed; background:#a1a1a1; padding:20px; bottom:20px; right:20px; width:200px; height:auto; z-index:99999" >${d.text}</div>`;
                            //$("body").append(mensagem);
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