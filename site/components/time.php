<head>
  <title>My Now Amazing Webpage</title>
  <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
  </head>
   
   
   <!-- ======= Team Section ======= -->
    <section id="time" class="team">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Time</h2>
        </div>

        <div class="row gy-5">


        <?php
            $query = "select * from time where situacao = '1' order by codigo desc";
            $result = mysqli_query($con, $query);
            while($d = mysqli_fetch_object($result)){

              $midias = json_decode($d->canais_contatos);

        ?>
          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img" style="height:320px">
                <img src="<?=$localPainel?>site/volume/time/<?=$d->imagem?>" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <?php
                    $midias_sociais = [
                      'facebook' => 'https://www.facebook.com/',
                      'twitter' => 'https://twitter.com/',
                      'instagram' => 'https://www.instagram.com/',
                      'youtube' => 'https://www.youtube.com/',
                      'linkedin' => 'https://www.linkedin.com/',
                      'whatsapp' => 'https://api.whatsapp.com/send?phone='
                    ];

                    foreach($midias_sociais as $ind => $url){
                      if($midias->$ind){
                  ?>
                  <a href="<?=$url.$midias->$ind?>" target="_black"><i class="bi bi-<?=$ind?>"></i></a>
                  <?php
                      }
                    }
                  ?>
                  <!-- <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a> -->
                </div>
                <h4><?=$d->nome?></h4>
                <span><?=$d->cargo?></span>
              </div>
            </div>
          </div>
          <?php
            }

            /*
          ?>

          <!-- End Team Member -->

          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                <h4>Sarah Jhonson</h4>
                <span>Programadora Senior</span>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                <h4>William Anderson</h4>
                <span>Designer de Web</span>
              </div>
            </div>
          </div><!-- End Team Member -->
            <?php
            //*/
            ?>
        </div>

      </div>
    </section><!-- End Team Section -->



   <div> <img src="https://w7.pngwing.com/pngs/562/239/png-transparent-powder-gold-particles-gold-gold-elements-powder.png" /></div>
    <div>your content</div>
    <div><img src="https://png.pngtree.com/png-clipart/20190710/ourlarge/pngtree-golden-glitter-frame-background-png-image_1540565.jpg" /></div> 
  <div class="autoplay">
    <div> <img src="https://w7.pngwing.com/pngs/562/239/png-transparent-powder-gold-particles-gold-gold-elements-powder.png" /></div>
    <div>your content</div>
    <div><img src="https://png.pngtree.com/png-clipart/20190710/ourlarge/pngtree-golden-glitter-frame-background-png-image_1540565.jpg" /></div>
  
  </div>

  <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="slick/slick.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.autoplay').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
});
    });

    
  </script>
