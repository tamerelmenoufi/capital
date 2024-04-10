
<style>
    
    .botaodiferente{
      background: #ffffff;
    border: 0;
    padding: 13px 50px;
    color: #393286;
    transition: 0.4s;
    border-radius: 25px;
    border-left: 10px #393286 solid;
    border-right: #393286 10px solid;
    border-top: #393286 solid 1px;
    border-bottom: #393286 solid 1px;
}

.botaodiferente:hover{
    background: #393286;
    border: 0;
    padding: 13px 50px;
    color: #fff;
    transition: 0.4s;
    border-radius: 25px;
    border-left: 10px #393286 solid;
    border-right: #393286 10px solid;
    border-top: #393286 solid 1px;
    border-bottom: #393286 solid 1px;
}



  </style>

<?php

    $query = "select * from configuracoes where codigo = '1'";
    $result = sisLog( $query);
    $d = mysqli_fetch_object($result);
?><!-- ======= Contact Section ======= -->
    <style>
      .contact .php-email-form textarea {
        padding: 10px 12px;
        height: 115px!important;
      }
    </style>

    <section id="contact" class="contact" style="padding:0px!important">
    

        <div style="background:#144397">
          <p style="color:#fff;font-size:25px;text-align:center;font-weight:bold;font-style:italic">Perguntas Frequentes</p>

          <p style="color:#fff;font-size:18px;text-align:center;">
      O que preciso para sacar meu FGTS?
        </p>

        <p style="color:#fff;font-size:18px;text-align:center;">
     Quais os documentos necessários para fazer a contratação?
        </p>

        <p style="color:#fff;font-size:18px;text-align:center;">
      Consigo fazer a contratação online?
        </p>

        <div style="padding:15px"> </div>
   <center> 
    <d style="padding:10px;background:#fcce00;color:#144397;font-size:25px;text-align:center;font-weight:bold">
    Fale conosco</d>
</center>

<div style="padding:15px"> </div>

    </div>

    

     
    </section><!-- End Contact Section -->


    <script>
      $(function(){
        $.ajax({
          url:"plugins/visualizar_mapa.php",
          success:function(dados){
            $(".exibir_mapa").html(dados);
          }
        });


        $( "form.php-email-form" ).on( "submit", function( event ) {

          event.preventDefault();
          // materia = editor.getData();
          data = $( this ).serialize();
          // data.push({name:'materia', value:editor});
          // console.log(data);

          $.ajax({
            url:"plugins/enviar_email.php",
            type:"POST",
            data,
            success:function(dados){

              $("#name").val('');
              $("#email").val('');
              $("#message").val('');

              $.alert({
                content:dados,
                type:"orange",
                title:false,
                buttons:{
                  'ok':{
                    text:'<i class="fa-solid fa-check"></i> OK',
                    btnClass:'btn btn-warning'
                  }
                }
              });

            }
          });
        });


      })
    </script>