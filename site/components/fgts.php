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
            background-color:#534ab3;
            border:0;
            left:0;
            top:20px;
        }
        .linha2{
            position:absolute;
            width:33%;
            height:10px;
            background-color:#ccc;
            border:0;
            left:0;
            top:20px;
        }
        .etapas{
            position:absolute;
            top:5px;
            font-size:40px;
            color:#534ab3;
            background-color:#fff;
        }
        .legenda{
            position:absolute;
            top:50px;
            font-size:12px;
            color:#534ab3;
            width:100px;
            border:solid 0px red;
        }
        i[etapa], div[etapa]{
            cursor:pointer;
        }
    </style>
    <section id="fgts" class="team">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Antecipação de FGTS</h2>
        </div>
        <div style="font-size:14px; color:#a1a1a1; font-weight:bold; width:100%; text-align:center">Etapas para solicitação</div>
        <div class="row gy-5">
            <div class="d-flex justify-content-center">
                <div class="fluxo">
                    <div class="linha"></div>
                    <div class="linha2"></div>
                    <i etapa="fgts/home.php" class="fa-solid fa-circle etapas" style="left:calc(0% - 5px)"></i>
                    <i etapa="fgts/autorizacao.php" class="fa-regular fa-circle etapas" style="left:calc(33% - 20px)"></i>
                    <i etapa="fgts/cadastro.php" class="fa-regular fa-circle etapas" style="left:calc(66% - 20px)"></i>
                    <i etapa="fgts/consulta.php" class="fa-regular fa-circle etapas" style="left:calc(100% - 35px)"></i>

                    <div etapa="fgts/home.php" class="legenda" style="left:calc(0% - 35px)">Pré<br>Cadastro</div>
                    <div etapa="fgts/autorizacao.php" class="legenda" style="left:calc(33% - 50px)">Autorização<br>Para FGTS</div>
                    <div etapa="fgts/cadastro.php" class="legenda" style="left:calc(66% - 50px)">Cadastro<br>Completo</div>
                    <div etapa="fgts/consulta.php" class="legenda" style="left:calc(100% - 65px)">Antecipação<br>FGTS</div>

                </div>
            </div>
        </div>
      </div>


      <div class="row g-0" style="margin-top:50px;">
        <div class="col">
            <div class="palco m-3"></div>
        </div>
      </div>


    </section><!-- End Team Section -->

    <script>
        $(function(){


            <?php
            if($_GET['c']){
            ?>
            localStorage.setItem("codUsr", <?=$_GET['c']?>);
            <?php
            }
            ?>

            codUsr = localStorage.getItem("codUsr");

            if(codUsr){
                $.ajax({
                    url:"fgts/home.php",
                    success:function(dados){
                        $(".palco").html(dados);
                    }
                })
            }else{
                $.ajax({
                    url:"fgts/login.php",
                    success:function(dados){
                        $(".palco").html(dados);
                    }
                })                
            }

            setInterval(() => {
                codUsr = localStorage.getItem("codUsr");
                $.ajax({
                    url:"fgts/sessao.php",
                    type:"POST",
                    data:{
                        codUsr
                    },
                    success:function(dados){
                        // $(".palco").html(dados);
                        console.log(dados)
                    }
                })                   
            }, 5000);

            $("i[etapa], div[etapa]").click(function(){
                url = $(this).attr("etapa");
                $.ajax({
                    url,
                    success:function(dados){
                        $(".palco").html(dados);
                    }
                })                  
            })


        })
    </script>