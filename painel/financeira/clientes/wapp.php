<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['acao'] == 'mensagem_lida'){
        $query = "update wapp_chat set recebida = '1' where codigo = '{$_POST['codigo_mensagem']}'";
        mysqli_query($con, $query);
        exit();
    }

    if($_POST['acao'] == 'enviar'){
        $query = "insert into wapp_chat set de = '{$_POST['de']}', para = '{$_POST['para']}', mensagem = '{$_POST['mensagem']}', usuario = '{$_SESSION['ProjectPainel']->codigo}', data = NOW()";
        if(mysqli_query($con, $query)){

            $wgw = new wgw;
            $wgw->SendTxt([
              'mensagem'=>$_POST['mensagem'],
              'para'=>'55'.$_POST['para']
            ]);

        }

        exit();
    }

    // if($_POST['acao'] == 'receber'){
    //     $query = "select * from wapp_chat where de = '{$_POST['de']}' and para = '{$_POST['para']}' and data > '{$_POST['ultimo_acesso']}' order by data desc ";
    //     $result = mysqli_query($con, $query);
    //     $retorno = [];
    //     $update = [];
    //     while($d = mysqli_fetch_object($result)){
    //         $retorno[] = [
    //             'de'=>$d->de,
    //             'para'=>$d->para,
    //             'mensagem'=>$d->mensagem,
    //             'data'=>dataBr($d->data),
    //             'ultimo_acesso'=>$d->data
    //         ];
    //         $update[] = $d->codigo;
    //     }
    //     echo json_encode($retorno);
    //     if($update){
    //         mysqli_query($con, "update wapp_chat set recebida = '1' where codigo in(".implode(', ', $update).") and recebida != '1'");
    //     }
    //     exit();
    // }

    $c = mysqli_fetch_object(mysqli_query($con, "select * from clientes where codigo = '{$_POST['mensagens']}'"));

    $phoneNumber = str_replace([' ','-','(',')'],false,trim($c->phoneNumber));

?>

<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        right:20px;
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
    div[listaClientesChat]{
        cursor:pointer;
    }


    /* Estilos do microfone */
    .microfone {
    width: 50px;
    height: 50px;
    background-color: transparent;
    border-radius: 50%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    /* Estilos do ícone de microfone */
    .icon {
    z-index:1;
    }

    /* Estilos do "rádio luminoso" */
    .radio {
        width: 50px;
        height: 50px;
        background-color: red;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: radio-pulse 1s ease-in-out infinite ;
        opacity:0;
    }

    /* Animação do "rádio luminoso" */
    @keyframes radio-pulse {
        0% {
            width: 5px;
            height: 5px;
        }
        100% {
            width: 50px;
            height: 50px;
            opacity: 0;
        }
    }
    /* Estilo do microfone */
    .microfone{
        cursor:pointer;
    }
    .exibe{
        display:block!important;
    }

    .oculta{
        display:none!important;
    }

    i[enviar]{
        cursor:pointer;
    }

</style>
<h4 class="Titulo<?=$md5?>">
    <div class="d-flex justify-content-between align-items-center">
        <span>Mensagens WhatsApp</span>
        <div style="position:relative" listaClientesChat="open">
            <span style="position:absolute; background-color:#dcf8c6; border-radius:100%; width:10px; height:10px; right:0px; top:-5px; opacity:0;"></span>
            <i class="fa-solid fa-comments"></i>
        </div>
        
    </div>
</h4>
<div class="topo<?=$md5?>"><i class="fa-regular fa-comment-dots"></i> <?=$c->nome?></div>
<div chatWindow="open" class="palco<?=$md5?>" up<?=$phoneNumber?>>
    <?php
        $query = "select * from wapp_chat where (de = '{$ConfWappNumero}' and para = '{$phoneNumber}' or de = '{$phoneNumber}' and para = '{$ConfWappNumero}') order by data asc";
        $result = mysqli_query($con, $query);
        $update = [];
        while($m = mysqli_fetch_object($result)){

            if($m->de == $ConfWappNumero){
    ?>
            <div class="d-flex flex-row-reverse">
                <div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#dcf8c6; border:0; border-radius:10px;">
                    <div class="text-start" style="border:solid 0px red;"><?=$m->mensagem?></div>
                    <div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;"><?=dataBr($m->data)?></div>
                </div>
            </div>
    <?php
            }else{

                $update[] = $m->codigo;
    ?>
            <div class="d-flex flex-row">
                <div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#ffffff; border:0; border-radius:10px;">
                    <div class="text-start" style="border:solid 0px red;"><?=$m->mensagem?></div>
                    <div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;"><?=dataBr($m->data)?></div>
                </div>
            </div>
    <?php
            }
            $ultimo_acesso = $m->data;
        }

        if($update){
            mysqli_query($con, "update wapp_chat set recebida = '1' where codigo in(".implode(', ', $update).") and recebida != '1'");
        }

        $msgs = mysqli_fetch_object(mysqli_query($con, "select count(*) as qt from wapp_chat where recebida != '1'"));
    ?>
</div>
<div class="rodape<?=$md5?>">
    <div class="d-flex justify-content-between align-items-center m-3">
        <div class="mensagem_texto exibe w-100">
            <div class="d-flex justify-content-between align-items-center w-100">
                <i class="fa-regular fa-face-smile p-3"></i>
                <input type="text" class="form-control p-3" id="chatMensagem" ultimo_acesso="<?=$ultimo_acesso?>" aria-describedby="chatMensagem">
            </div>
        </div>
        <div class="mensagem_audio oculta w-100">
            <div class="d-flex justify-content-between align-items-center w-100">
                <i statusGravacao="gravando" class="fa-solid fa-microphone p-2 text-danger"></i>
                <div class="form-control">  <audio controls id="audioPlayer" style="display:none; height:40px;"></audio> <span class="m-2" gravando>Gravando ...</span></div>
            </div>
        </div>        
        <div class="microfone" acao="normal">
            <div class="radio"></div>
            <i class="fa-solid fa-microphone p-3 icon"></i>
        </div>
        <i enviar class="fa-regular fa-paper-plane p-3"></i>
    </div>
</div>

<script>
    $(function(){

        Carregando('none');
        
        altura = $(".palco<?=$md5?>").prop("scrollHeight");
        div = $(".palco<?=$md5?>").height();
        $(".palco<?=$md5?>").scrollTop(altura + div);
        $(".toast").remove();
        

        if($("div[listaClientesChat]").attr("listaClientesChat") == 'open'){
            $(this).children("span").css("opacity",'<?=(($msgs->qt)?'1':'0')?>');
        }


        ///////////////////////////////////////FUNCAO DO AUDIO//////////////////////////////////
        var mediaRecorder;
        var chunks = [];
        $(".microfone").click(function(){
            acao = $(this).attr("acao");

            if(acao == "normal"){
                
                chunks = [];
                $(".radio").css("opacity","1");
                $(".mensagem_texto").removeClass("exibe");
                $(".mensagem_texto").addClass("oculta");
                
                $(".mensagem_audio").removeClass("oculta");
                $(".mensagem_audio").addClass("exibe");

                $("#audioPlayer").css("display","none");
                $("span[gravando]").css("display","block");

                $("i[statusGravacao]").addClass("fa-microphone");
                $("i[statusGravacao]").removeClass("fa-trash-can");
                $("i[statusGravacao]").attr("statusGravacao","gravando");

                /////////////Gravação/////////////////////
                console.log('audio iniciado')
                navigator.mediaDevices.getUserMedia({audio: true})
                .then(function(stream) {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = function(e) {
                        chunks.push(e.data);
                    };
                    mediaRecorder.start();
                })
                .catch(function(err) {
                    console.error('Erro ao acessar o microfone: ', err);
                });
                ////////Fim da gravação////////////////////////

                
                $(this).attr("acao","gravando");
            }else{
                $(".radio").css("opacity","0");
                $('#audioPlayer').attr('src', '');
                ///////////////Iniçio da açao de gravação/////////////////////////
                console.log('audio finalizado')
                if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                console.log('audio acao')
                    mediaRecorder.stop();
                    mediaRecorder.onstop = function() {
                        var blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });
                        // var audioURL = URL.createObjectURL(blob);

                        var reader = new FileReader();
                        reader.onload = function(event) {
                            var base64Data = event.target.result;
                            // Use a base64Data conforme necessário, por exemplo, envie para o servidor
                            $('#audioPlayer').attr('src', base64Data);
                        };
                        reader.readAsDataURL(blob);

                        // $('#audioPlayer').attr('src', audioURL);
                        // $('#audioPlayer').show();
                        $("#audioPlayer").css("display","block");
                        $("span[gravando]").css("display","none");

                        $("i[statusGravacao]").removeClass("fa-microphone");
                        $("i[statusGravacao]").addClass("fa-trash-can");
                        $("i[statusGravacao]").attr("statusGravacao","play");
                    };
                }  
                /////////////////Fim da ação//////////////////////////////////////


                
                $(this).attr("acao","normal");
            }
        })

        $("i[statusGravacao]").click(function(){
            acao = $(this).attr("statusGravacao");
            if(acao == 'play'){
                var audioPlayer = $('#audioPlayer')[0];
                $(".mensagem_texto").removeClass("oculta");
                $(".mensagem_texto").addClass("exibe");
                
                $(".mensagem_audio").removeClass("exibe");
                $(".mensagem_audio").addClass("oculta"); 

                if (!audioPlayer.paused) {
                    audioPlayer.pause();
                    $('#audioPlayer').removeAttr("src");
                }

            }

        })

        //////////////////////////////////////FUNCAO DO AUDIO//////////////////////////////////


        function EnviaMensagemText(val){
            
            layout = '<div class="d-flex flex-row-reverse">'+
                     '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#dcf8c6; border:0; border-radius:10px;">'+
                     '<div class="text-start" style="border:solid 0px red;">'+val+'</div>' +
                     '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">12:17</div>' +
                     '</div>' +
                     '</div>';

            $(".palco<?=$md5?>").append(layout);

            $("#chatMensagem").val('');

            altura = $(".palco<?=$md5?>").prop("scrollHeight");
            div = $(".palco<?=$md5?>").height();
            $(".palco<?=$md5?>").scrollTop(altura + div);

            $.ajax({
                url:"financeira/clientes/wapp.php",
                type:"POST",
                data:{
                    mensagem:val,
                    de:'<?=$ConfWappNumero?>',
                    para:'<?=$phoneNumber?>',
                    acao:'enviar'
                },
                success:function(dados){

                }
            })
        }
        
        
        $("#chatMensagem").keypress(function(e){
            val = $(this).val();
            if(e.which == 13 && val) {
                EnviaMensagemText(val);
            }
        });

        $("div[listaClientesChat]").click(function(){
            Carregando();
            $.ajax({
                    url:"financeira/clientes/wapp_lista.php",
                    success:function(dados){
                        $(".LateralDireita").html(dados);
                    }
                })
        })

        $("i[enviar]").off('click').on('click', function(){
            audio = '';
            val = '';
            base64 = [];
            audio = $('#audioPlayer').attr("src");
            val = $("#chatMensagem").val();

            if(audio){
                base64 = audio.split('base64,');
                console.log('audio:'+base64[1])
            }else if(val) {
                //EnviaMensagemText(val);
                console.log('text:'+val)
            }

        });

        // verificarMensagem = setInterval(() => {
        //     ultimo_acesso = $("#chatMensagem").attr("ultimo_acesso");
        //     $.ajax({
        //         url:"financeira/clientes/wapp.php",
        //         type:"POST",
        //         dataType:"JSON",
        //         data:{
        //             de:'<?=$phoneNumber?>',
        //             para:'<?=$ConfWappNumero?>',
        //             ultimo_acesso,
        //             acao:'receber'
        //         },
        //         success:function(dados){

        //             console.log(dados);

        //             $.each(dados, function () {

        //                 layout = '<div class="d-flex flex-row">'+
        //                 '<div class="d-inline-flex flex-column m-1 p-2" style="max-width:60%; background-color:#ffffff; border:0; border-radius:10px;">'+
        //                 '<div class="text-start" style="border:solid 0px red;">'+this.mensagem+'</div>' +
        //                 '<div class="text-end" style="color:#b6a29a; font-size:10px; border:solid 0px black;">'+this.data+'</div>' +
        //                 '</div>' +
        //                 '</div>';

        //                 $(".palco<?=$md5?>").append(layout);

        //                 altura = $(".palco<?=$md5?>").prop("scrollHeight");
        //                 div = $(".palco<?=$md5?>").height();
        //                 $(".palco<?=$md5?>").scrollTop(altura + div);    
        //                 $("#chatMensagem").attr('ultimo_acesso', this.ultimo_acesso);   

        //             })

        //         }
        //     });
        // }, 10000);

    })
</script>