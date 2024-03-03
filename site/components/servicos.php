    <!-- ======= Recent Blog Posts Section ======= -->

    <style>
  .recent-blog-posts .post-box:hover .post-title {
    color: #057a34;}

    .botaoverde{
      padding: 15px;
    padding-left: 35px;
    padding-right: 35px;
    border: 1px solid #198754;
    background: #198754;
    color: #fff;
    border-radius: 25px 2px 25px;
    font-size: 17px;
    }

  </style>
    <section id="servicos"  style="padding:0px" class="recent-blog-posts">

      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Nossos serviços</h2>
        </div>

        <div class="row">


          <?php
          $query = "select * from servicos where situacao = '1' order by codigo desc limit 0,3";
          $result = mysqli_query($con, $query);
          while($d = mysqli_fetch_object($result)){
          ?>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="post-box">
              <div style="margin-top:10px;height:267px" class="post-img"><img src="<?=$localPainel?>site/volume/servicos/<?=$d->imagem?>" class="img-fluid" alt=""></div>
              <!-- <div class="meta">
                <span class="post-date">Tue, December 12</span>
                <span class="post-author"> / Julia Parker</span>
              </div> -->
              <h3 class="post-title" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?=$d->titulo?></h3>
              <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"><?=strip_tags(str_replace('<',' <',str_replace('>','> ',$d->materia)))?></p>
              <a href="servico.php?cod=<?=$d->codigo?>" class="mt-3 mb-3">
                <button type="button" class="btn btn-outline-success">Leia Mais<i class="bi bi-arrow-right"></i></button>
              </a>
            </div>
          </div>

          <?php
          }
          ?>

          <!-- <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="post-box">
              <div class="post-img"><img src="assets/img/blog/blog-2.jpg" class="img-fluid" alt=""></div>
              <div class="meta">
                <span class="post-date">Fri, September 05</span>
                <span class="post-author"> / Mario Douglas</span>
              </div>
              <h3 class="post-title">Et repellendus molestiae qui est sed omnis voluptates magnam</h3>
              <p>Voluptatem nesciunt omnis libero autem tempora enim ut ipsam id. Odit quia ab eum assumenda. Quisquam omnis aliquid necessitatibus tempora consectetur doloribus...</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
            <div class="post-box">
              <div class="post-img"><img src="assets/img/blog/blog-3.jpg" class="img-fluid" alt=""></div>
              <div class="meta">
                <span class="post-date">Tue, July 27</span>
                <span class="post-author"> / Lisa Hunter</span>
              </div>
              <h3 class="post-title">Quia assumenda est et veritatis aut quae</h3>
              <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis repellat sed quae consectetur magnam veritatis dicta nihil...</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div> -->


          <center style="margin-top:20px">
          <a href="servico_categoria.php">
         <button type="button" class="botaoverde">
          Outros serviços
        </button></a>
      </center>


        </div>

      </div>

    </section><!-- End Recent Blog Posts Section -->