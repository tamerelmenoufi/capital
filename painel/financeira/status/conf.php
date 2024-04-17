<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

        print_r($_POST);

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
    <button novo type="button" class="btn btn-success btn-sm">Novo</button>
</div>
<?php
    $query = "select * from ststus_mensagem where status = '{$d->codigo}' order by codigo desc";
    $result = mysqli_query($con, $query);
    while($m = mysqli_fetch_object($result)){
?>
<div class="card">
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
            <div>
                Arquivo Anexo
            </div>
        </div>
        <?php  
                }


            }elseif($m->tipo == 'img'){
                echo "<div class='d-flex justify-content-center'><img class='img-fluid' src='{$m->arquivo}' /></div>";
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
        <p></p>
  </div>
</div>
<?php
    }
?>