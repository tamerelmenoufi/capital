<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['acao'] == 'enviar'){
        $query = "insert into wapp_chat set de = '{$_POST['de']}', para = '{$_POST['para']}', mensagem = '{$_POST['mensagem']}', usuario = '{$_SESSION['ProjectPainel']->codigo}', data = NOW()";
        mysqli_query($con, $query);
        exit();
    }

    if($_POST['acao'] == 'receber'){
        $query = "select * from wapp_chat where de '{$_POST['de']}' and para = '{$_POST['para']}' and data > '{$_POST['data']}' order by data desc ";
        $result = mysqli_query($con, $query);
        $retorno = [];
        while($d = mysqli_fetch_object($result)){
            $retorno[] = [
                'de'=>$d->de,
                'para'=>$d->para,
                'data'=>dataBr($d->data),
                'ultimo_acesso'=>$d->data
            ];
        }
        echo json_encode($retorno);
        exit();
    }

    $c = mysqli_fetch_object(mysqli_query($con, "select * from clientes where codigo = '{$_POST['mensagens']}'"));

?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
    .topo<?=$md5?>{
        position:absolute;
        background:#eee;
        left:0;
        right:0;
        height:40px;
        top:50px;
        padding:10px;
    }
    .palco<?=$md5?>{
        position:absolute;
        left:0;
        top:90px;
        bottom:85px;
        right:0;
        background-color:#f7f7f7;
        overflow:auto;
        border-left:3px solid #e4e4e4;
        padding:10px;      
    }    
    .rodape<?=$md5?>{
        position:absolute;
        background:#eee;
        left:0;
        right:0;
        bottom:0px;    
        height:85px;    
    }
</style>
<h4 class="Titulo<?=$md5?>">Mensagens WhatsApp</h4>
<div class="topo<?=$md5?>"><i class="fa-regular fa-comment-dots"></i> <?=$c->nome?></div>
<div class="palco<?=$md5?>"></div>
<div class="rodape<?=$md5?>">
    <div class="d-flex justify-content-between align-items-center m-3">
        <i class="fa-regular fa-face-smile p-3"></i>
        <input type="text" class="form-control p-3" id="chatMensagem" ultimo_acesso="<?=$ultimo_acesso?>" aria-describedby="chatMensagem">
        <i class="fa-solid fa-microphone p-3"></i>
        <i class="fa-regular fa-paper-plane p-3"></i>
    </div>
</div>

<script>
    $(function(){
        
        


        $("#chatMensagem").keypress(function(e){
            val = $(this).val();
            layout = '<div class="d-flex flex-row-reverse">'+
                     '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#dcf8c6; border:0; border-radius:10px;">'+
                     '<div class="text-start" style="border:solid 0px red;">'+val+'</div>' +
                     '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">12:17</div>' +
                     '</div>' +
                     '</div>';

            layout2 = '<div class="d-flex flex-row">'+
                     '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#ffffff; border:0; border-radius:10px;">'+
                     '<div class="text-start" style="border:solid 0px red;">'+val+'</div>' +
                     '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">12:17</div>' +
                     '</div>' +
                     '</div>';

            if(e.which == 13 && val) {
                $(".palco<?=$md5?>").append(layout);
                $(".palco<?=$md5?>").append(layout2);
                $("#chatMensagem").val('');

                altura = $(".palco<?=$md5?>").prop("scrollHeight");
                div = $(".palco<?=$md5?>").height();
                $(".palco<?=$md5?>").scrollTop(altura + div);

                $.ajax({
                    url:"financeira/clientes/wapp.php",
                    type:"POST",
                    data:{
                        mensagem:val,
                        de:'<?=str_replace([' ','-','(',')'],false,trim($ConfWappNumero))?>',
                        para:'<?=str_replace([' ','-','(',')'],false,trim($c->phoneNumber))?>',
                        acao:'enviar'
                    },
                    success:function(dados){

                    }
                })
            }
        });


        verificarMensagem = setInterval(() => {
            $.ajax({
                url:"inanceira/clientes/wapp.php",
                type:"POST",
                dataType:"JSON",
                data:{
                    de:'<?=str_replace([' ','-','(',')'],false,trim($c->phoneNumber))?>',
                    para:'<?=str_replace([' ','-','(',')'],false,trim($ConfWappNumero))?>',
                    acao:'receber'
                },
                success:function(dados){

                    dados.each(function(r){

                        layout = '<div class="d-flex flex-row">'+
                        '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#ffffff; border:0; border-radius:10px;">'+
                        '<div class="text-start" style="border:solid 0px red;">'+r.mensagem+'</div>' +
                        '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">'+r.data+'</div>' +
                        '</div>' +
                        '</div>';

                        $(".palco<?=$md5?>").append(layout);

                        altura = $(".palco<?=$md5?>").prop("scrollHeight");
                        div = $(".palco<?=$md5?>").height();
                        $(".palco<?=$md5?>").scrollTop(altura + div);    
                        $("#chatMensagem").attr('ultimo_acesso', r.ultimo_acesso);                    
                    })

                    console.log(dados);
                }
            });
        }, 1000);

    })
</script>