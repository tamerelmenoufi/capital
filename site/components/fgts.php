    <!-- ======= FGTS Section ======= -->
    <style>
        .fluxo{
            width:90%;
            height:50px;
            position:relative;
            border:solid 0px red;
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
            background-color:#fff;
        }
        .legenda{
            position:absolute;
            top:50px;
            font-size:12px;
            color:green;
            width:100px;
            border:solid 0px red;
        }
    </style>
    <section id="fgts" class="team">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Antecipação de FGTS</h2>
        </div>
        <div class="row gy-5">
            <p style="font-size:14px; font-weight:bold">Etapas para solicitação</p>
            <div class="d-flex justify-content-center">
                <div class="fluxo">
                    <div class="linha"></div>
                    <i class="fa-solid fa-circle etapas" style="left:calc(0% - 5px)"></i>
                    <i class="fa-solid fa-circle etapas" style="left:calc(33% - 20px)"></i>
                    <i class="fa-solid fa-circle etapas" style="left:calc(66% - 20px)"></i>
                    <i class="fa-regular fa-circle etapas" style="left:calc(100% - 35px)"></i>

                    <div class="legenda" style="left:calc(0% - 35px)">Pré<br>Cadastro</div>
                    <div class="legenda" style="left:calc(33% - 50px)">Autorização<br>Para FGTS</div>
                    <div class="legenda" style="left:calc(66% - 50px)">Cadastro<br>Completo</div>
                    <div class="legenda" style="left:calc(100% - 65px)">Antecipação<br>FGTS</div>

                </div>
            </div>
        </div>
      </div>
    </section><!-- End Team Section -->