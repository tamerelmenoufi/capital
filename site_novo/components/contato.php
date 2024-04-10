
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

      

      <div class="exibir_mapa">
      <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3984.0578054013845!2d-60.02677828524287!3d-3.07924319775767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zM8KwMDQnNDUuMyJTIDYwwrAwMScyOC41Ilc!5e0!3m2!1spt-BR!2sbr!4v1675953069641!5m2!1spt-BR!2sbr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="container">

        <div class="row gy-5 gx-lg-5">

          <div class="col-lg-5">

            <div class="info">
              <h3>Entre em contato</h3>




              <div class="info-item d-flex">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h4>E-mail:</h4>
                  <p><?=$d->email?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-phone flex-shrink-0"></i>
                <div>
                  <h4>Telefone:</h4>
                  <p><?=$d->telefone?></p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-7">
            <form class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nome Completo" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
                </div>
              </div>

              <div class="form-group mt-3">
                <textarea class="form-control" name="message" id="message" placeholder="Sua mensagem" required></textarea>
              </div>
              <div class="text-center"><button type="submit" class="botaodiferente" style="
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
              "
              >Enviar</button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>

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