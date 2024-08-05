    <!-- ======= Banner-reels Section ======= -->
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
            height:10px;
            background-color:#534ab3;
            border:0;
            left:0;
            top:20px;
        }
        .linha2{
            position:absolute;
            width:100%;
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
  <html amp lang="en">
  <head>
    <meta charset="utf-8" />
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script
      async
      custom-element="amp-story"
      src="https://cdn.ampproject.org/v0/amp-story-1.0.js"
    ></script>
    <title>Hello, amp-story</title>
    <link rel="canonical" href="http://example.ampproject.org/my-story.html" />
    <meta
      name="viewport"
      content="width=device-width,minimum-scale=1,initial-scale=1"
    />
    <style amp-boilerplate>
      body {
        -webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
        -moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
        -ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
        animation: -amp-start 8s steps(1, end) 0s 1 normal both;
      }
      @-webkit-keyframes -amp-start {
        from {
          visibility: hidden;
        }
        to {
          visibility: visible;
        }
      }
      @-moz-keyframes -amp-start {
        from {
          visibility: hidden;
        }
        to {
          visibility: visible;
        }
      }
      @-ms-keyframes -amp-start {
        from {
          visibility: hidden;
        }
        to {
          visibility: visible;
        }
      }
      @-o-keyframes -amp-start {
        from {
          visibility: hidden;
        }
        to {
          visibility: visible;
        }
      }
      @keyframes -amp-start {
        from {
          visibility: hidden;
        }
        to {
          visibility: visible;
        }
      }
    </style>
    <noscript
      ><style amp-boilerplate>
        body {
          -webkit-animation: none;
          -moz-animation: none;
          -ms-animation: none;
          animation: none;
        }
      </style></noscript
    >
  </head>
  <body>
    <amp-story
      standalone
      title="Hello Story"
      publisher="The AMP Team"
      publisher-logo-src="https://example.com/logo/1x1.png"
      poster-portrait-src="https://example.com/my-story/poster/3x4.jpg"
    >
      <amp-story-page id="my-first-page">
        <amp-story-grid-layer template="fill">
          <amp-img
            src="assets/img/capital.jpg"
            width="900"
            height="1600"
            alt=""
          >
          </amp-img>
        </amp-story-grid-layer>

        <amp-story-grid-layer template="vertical">
         
        </amp-story-grid-layer>

      </amp-story-page>
      <amp-story-page id="my-second-page">
        <amp-story-grid-layer template="fill">
          <amp-img
            src="assets/img/capital-01.gif"
            width="900"
            height="1600"
            alt=""
          >
          </amp-img>

        </amp-story-grid-layer>
        <amp-story-grid-layer template="vertical">
          
        </amp-story-grid-layer>
      </amp-story-page>

      <amp-story-page id="my-second-page">
        <amp-story-grid-layer template="fill">
          <amp-img
            src="assets/img/capital-03.gif"
            width="900"
            height="1600"
            alt=""
          >
          </amp-img>

        </amp-story-grid-layer>
        <amp-story-grid-layer template="vertical">
          
        </amp-story-grid-layer>
      </amp-story-page>





    </amp-story>
  </body>
</html>



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
                    url:"fgts/sessao.php",
                    type:"POST",
                    data:{
                        codUsr
                    },
                    success:function(dados){
                        $.ajax({
                            url:"fgts/home.php",
                            success:function(dados){
                                $(".palco").html(dados);
                            }
                        })
                    }
                })   


            }else{
                $.ajax({
                    url:"fgts/index.php",
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
                acao = $(this).attr("acao");
                if(acao == 'blq') return false;
                $.ajax({
                    url,
                    success:function(dados){
                        $(".palco").html(dados);
                    }
                })                  
            })


        })
    </script>