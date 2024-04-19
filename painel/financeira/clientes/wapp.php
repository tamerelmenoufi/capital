<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

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
        background:yellow;
        left:0;
        right:0;
        bottom:150px;
        top:90px;        
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
        <input type="text" class="form-control p-3" id="chatMensagem" aria-describedby="chatMensagem">
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

            if(e.which == 13 && val) {
                $(".palco<?=$md5?>").append(layout);
                $("#chatMensagem").val('');

                altura = $(".palco<?=$md5?>").prop("scrollHeight");
                div = $(".palco<?=$md5?>").height();
                $(".palco<?=$md5?>").scrollTop(altura + div);


                // console.log('precionei o teclado!' + val)
            }
        });
    })
</script>