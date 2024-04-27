<style>
    .toast-container{
        position:fixed!important;
    }
    .toast-body{
        cursor:pointer;
    }
</style>

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
                        
                        if(d.de == '92991886570' && $("div[chatWindow]").attr("chatWindow") == "open"){
                        chatAtivo = $(`div[up${d.de}]`).attr("ativo");
                        if(!chatAtivo){
                            alerta = `<div popup${d.de} class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                            <div class="toast-header">
                                                <img src="img/icone.php" class="rounded me-2" alt="...">
                                                <strong class="me-auto">${d.de}</strong>
                                                <small>11 mins ago</small>
                                                <button close="${d.de}" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div 
                                                class="toast-body"
                                                
                                                abrirMensagem="${d.codigo}"
                                            >
                                                ${d.text}
                                            </div>
                                        </div>`;
                            $(".toast-container").append(alerta);
                            $(`div[popup${d.de}]`).show();
                            console.log(alerta)
                        }
                        }
                    }
                }                    
            })

        });
        //websocked   


        $(document).on("click","button[close]",function() {
            janela = $(this).attr("close");
            // $(`div[popup${janela}]`).remove();
            $(this).parent("div").parent("div").remove();
        });


        $("div[abrirMensagem]").click(function(){
            mensagens = $(this).attr("abrirMensagem");
            $(".toast").remove();
            $.ajax({
                url:"financeira/clientes/wapp.php",
                type:"POST",
                data:{
                    mensagens
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })



    })
</script>