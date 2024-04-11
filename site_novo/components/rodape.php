
  <style>

/* .footer .footer-legal {
  padding: 30px 0;
  background: #057a34!important;
} */

.footer .footer-legal .social-links a:hover {

    text-decoration: none;
}

.footer .footer-legal {
    padding: 30px 0;
background:none;
}
  </style>

  <!-- ======= Footer ======= -->
  

<footer id="footer" class="footer" style="background:#144397">
<div class="container text-center footer-legal" >
  <div class="row align-items-center">
    <div class="col-3">
    <p style="color:#fff;font-size:18px;text-align:center;font-weight:bold;font-style:italic;margin-bottom:0px">UNIDADE CIDADE NOVA</p>
<p style="color:#fff">Rua Prof. felix Valois, 61<br> Cidade nova</p>
    </div>
    <div class="col-3">
    <p style="color:#fff;font-size:18px;text-align:center;font-weight:bold;font-style:italic;margin-bottom:0px">UNIDADE MANOA</p>
<p style="color:#fff">Av. Francisco Queiroz, 02 - <br> Manoa</p>

    </div>
    <div class="col-6">
      <div class="social-links">
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
  </div>
</div>

<div style="text-align:center;font-size:14px"> &copy; Copyright <strong><span>capitalsolucoes</span></strong>. 
<a style="color:#fff; text-decoration-style:underline" href="#">Todos os direitos reservados </a></div>


</footer>


