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

<div class="card">
    <div class="card-header">
        Pré-Cadastro
    </div>
    <div class="card-body">
        <h5 class="card-title">Faça a sua identificação</h5>
        <p class="card-text">Digite o seu telefone de contato para receber as credencias de acesso</p>
        
        <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-mobile-screen-button"></i></span>
            <input type="text" id="telefone" class="form-control" inputmode="numeric" placeholder="Digite seu telefone" aria-label="Telefone" aria-describedby="addon-wrapping" >
            <button class="btn btn-outline-secondary enviar" type="button" id="button-addon1">Enviar</button>
        </div>
        <p style="color:#534ab3; font-size:12px">Enviaremos um SMS ou WhatsApp com código de confirmação do seu do seu acesso.</p>

    </div>
    </div>
</div>

<script>
    $(function(){
        $("#telefone").mask("(99) 99999-9999");

        $(".enviar").click(function(){
            telefone = $("#telefone").val();
            if(!telefone){
                $.alert({
                    type:"red",
                    title:"Erro der Identificação",
                    content: 'Favor Digite o número de seu telefone!'
                })

                return false;
            }
            alert($("#telefone").length)

            if($("#telefone").length != 15){
                $.alert({
                    type:"red",
                    title:"Erro der Identificação",
                    content: 'O telefone informado não está correto!'
                })

                return false;                
            }
        })

    })
</script>