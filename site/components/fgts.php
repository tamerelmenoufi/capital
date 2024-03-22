    <!-- ======= FGTS Section ======= -->
    <style>
        .fluxo{
            width:90%;
            height:50px;
            position:relative;
            border:solid 1px red;
            text-align:center;
        }
        .linha{
            position:absolute;
            width:100%;
            height:10px;
            background-color:green;
            border:0;
            left:0;
            top:20px;
        }
        .etapas{
            position:absolute;
            top:5px;
            font-size:40px;
            color:green;
        }
        .legenda{
            position:absolute;
            top:30px;
            font-size:12px;
            color:green;
            width:100px;
            border:solid 1px red;
        }
    </style>
    <section id="fgts" class="team">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Antecipação de FGTS</h2>
        </div>
        <div class="row gy-5">
            <div class="d-flex justify-content-center">
                <div class="fluxo">
                    <div class="linha"></div>
                    <i class="fa-solid fa-circle etapas" style="left:calc(0% - 5px)"></i>
                    <i class="fa-solid fa-circle etapas" style="left:calc(33% - 20px)"></i>
                    <i class="fa-solid fa-circle etapas" style="left:calc(66% - 20px)"></i>
                    <i class="fa-solid fa-circle etapas" style="left:calc(100% - 35px)"></i>

                    <div class="legenda" style="left:calc(0% - 50px)">Etapa 1</div>
                    <div class="legenda" style="left:calc(33% - 50px)">Etapa 1</div>
                    <div class="legenda" style="left:calc(66% - 50px)">Etapa 2</div>
                    <div class="legenda" style="left:calc(100% - 50px)">Etapa 3</div>

                </div>
            </div>
        </div>
      </div>
    </section><!-- End Team Section -->