<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

        $query = "select * from status where codigo = '{$_POST['cod']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>">Mensagens - Wapp</h4>

<h5><?="{$d->status} - {$d->descricao}"?></h5>

<div class="d-flex flex-row-reverse">
    <button novo type="button" class="btn btn-success btn-sm"><i class="fa-solid fa-comment-medical"></i> Novo</button>
</div>
<?php
    $query = "select * from status_mensagens where status = '{$d->codigo}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($m = mysqli_fetch_object($result)){
?>
<div class="card mt-3">
  <div class="card-header">
    <?=$m->nome?>
  </div>
  <div class="card-body">
        <?php
            if($m->tipo == 'arq'){

                if(in_array($m->tipo_arquivo, ["ogg","mp3"])){
        ?>
        <audio controls>
        <source src="volume/wapp/status/<?="{$d->codigo}/{$m->arquivo}"?>" type="audio/ogg">
        <source src="volume/wapp/status/<?="{$d->codigo}/{$m->arquivo}"?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <?php
                }elseif(in_array($m->tipo_arquivo, ["mp4"])){
        ?>
        <video width="100%" height="auto" controls>
        <source src="volume/wapp/status/<?="{$d->codigo}/{$m->arquivo}"?>" type="audio/ogg">
        <source src="volume/wapp/status/<?="{$d->codigo}/{$m->arquivo}"?>" type="audio/mpeg">
            Your browser does not support the video tag.
        </video>
        <?php           
                }else{
        ?>
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <i class="fa-solid fa-file-lines"></i>
            <a style="margin-right:10px;" href="volume/wapp/status/<?="{$d->codigo}/{$m->arquivo}"?>" target="_blank">
                Arquivo Anexo
            </a>
        </div>
        <?php  
                }


            }elseif($m->tipo == 'img'){
                echo "<div class='d-flex justify-content-center'><img class='img-fluid' src='volume/wapp/status/{$d->codigo}/{$m->arquivo}' /></div>";
            }
            if($m->mensagem){
                echo "<p>{$m->mensagem}</p>";
            }
            
        ?>
        <div class="d-flex justify-content-between">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Disponibilizar mensagem</label>
            </div>
            <button class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Excluir</button>
        </div>
  </div>
</div>
<?php
    }
?>

<script>
    $(function(){

        $("button[novo]").click(function(){
            $.ajax({
                url:"financeira/status/conf_form.php",
                type:"POST",
                data:{
                    cod:'<?=$d->codigo?>'
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                    // let myOffCanvas = document.getElementById('offcanvasDireita');
                    // let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                    // openedCanvas.hide();
                }
            });            
        })


    })
</script>