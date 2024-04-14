<?php

$query = "select * from destaques";
$result = sisLog( $query);
$d = mysqli_fetch_object($result);

?>

<section id="destaque" class="about">
<div class="container">

<div class="row">

<div class="col-lg-6">
<div> 
  <a <?=(($d->video)?"href='{$d->video}' class='glightbox btn-watch-video d-flex align-items-center'":false)?> >
    <img class="img-fluid" src="<?=$localPainel?>site/volume/destaques/<?=$d->imagem?>" style="max-height:550px"/>
  </a>
</div>
</div>


<div class="col-lg-6">
  <div style="color:#144397">
  <div style="padding:30px"> </div>

    <p style="font-size:35px;font-weight:bold;text-align:center"> <?=$d->titulo?> </p>
    <p><?=$d->materia?></p>
   
   <div style="padding:30px"> </div>
   <center> 
    <d style="padding:10px;background:#fcce00;color:144397;font-size:25px;text-align:center;font-weight:bold">
    Faça sua simulação</d>
</center>
</div>
</div>

</div>
</div>
</section>