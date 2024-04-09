
  <style>

/* .footer .footer-legal {
  padding: 30px 0;
  background: #057a34!important;
} */

.footer .footer-legal .social-links a:hover {
    background: #534ab3;
    text-decoration: none;
}
  </style>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">


    <div class="footer-legal text-center" style="background:#144397">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright" style="font-weight:bold">
            &copy; Copyright <strong><span>capitalsolucoes</span></strong>. Todos os direitos reservados


            <p style="color:#fff">
            A Vip Promotora não é uma instituição financeira e não realiza operações de crédito diretamente. A Vip Promotora é uma plataforma digital que atua como correspondente bancário para facilitar o processo de contratação de empréstimos. Como correspondente bancário, seguimos as diretrizes do Banco Central do Brasil, nos termos da Resolução nº. 3.954, de 24 de fevereiro de 2011. Toda avaliação de crédito será realizada conforme a política de crédito da Instituição Financeira escolhida pelo usuário.Antes da contratação de qualquer serviço através de nossos parceiros, você receberá todas as condições e informações relativas ao produto a ser contrato,de forma completa e transparente. As taxas de juros, margem consignável e prazo de pagamento praticados nos empréstimos com consignação em pagamentodos Governos Federais, Estaduais e Municipais, Forças armadas e INSS observam as determinações de cada convênio, bem como a política de créditoda instituição financeira a ser utilizada. AOM SOLUCOES FINANCEIRAS
            </p> 

            <p style="color:#fff">- CNPJ 33.636.801/0001-05 | Endereço: Rua Castro Alves, 176 - Andar 1 - 88101-160 - Campinas, São José -SC</p>
           
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->

          </div>
        </div>

       <!-- <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
        <?php

          $query = "select * from configuracoes where codigo = '1'";
          $result = sisLog( $query);
          $d = mysqli_fetch_object($result);

          $midias = json_decode($d->midias_sociais);

          $midias_sociais = [
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://instagram.com/',
            'youtube' => 'https://www.youtube.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'whatsapp' => 'https://api.whatsapp.com/send?phone='
          ];

          foreach($midias_sociais as $ind => $url){
            if($midias->$ind){
        ?>
        <a href="<?=$url.$midias->$ind?>" target="_black" class="<?=$ind?>"><i class="bi bi-<?=$ind?>"></i></a>
        <?php
            }
          }
        ?>
        </div>

      </div>
    </div>-->

  </footer><!-- End Footer -->