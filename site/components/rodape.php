
  <style>

.footer .footer-legal {
  padding: 30px 0;
  background: #057a34!important;
}
  </style>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">


    <div class="footer-legal text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright">
            &copy; Copyright <strong><span>PfGeoTecnologia</span></strong>. Todos os direitos reservados
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->

          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
        <?php

          $query = "select * from configuracoes where codigo = '1'";
          $result = mysqli_query($con, $query);
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
    </div>

  </footer><!-- End Footer -->