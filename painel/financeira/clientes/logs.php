<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['detalhes']){
        $detalhes = json_decode(base64_decode($_POST['detalhes']));
        $detalhes = json_encode($detalhes, JSON_PRETTY_PRINT);
        echo "{$detalhes}";
        exit();
    }

    $query = "select * from consultas_log where cliente = '{$_POST['cliente']}' order by data desc";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
        $sessoes =  json_decode($d->sessoes);
        $log = json_decode($d->log);

        if($sessoes->acao == 'cron'){
            $titulo = "Sistema";
            if($log->statusCode){
                $descricao = "{$log->statusCode} - {$log->message}";
                $detalhes = base64_encode($d->log);
            }else if($log->proposalStatusId){
                $descricao = "{$log->proposalStatusId} - {$log->proposalStatusDisplayTitle}";
                $detalhes = base64_encode($d->log);
            }
        }

?>
    <div class="card mb-3">
    <div class="card-header">
        <?=$titulo?>
    </div>
    <div class="card-body">
        <p class="card-text"><?=$descricao?></p>
        <a detalhes="<?=$detalhes?>" class="btn btn-warning btn-sm">Log</a>
    </div>
    </div>
<?php
    }
?>

<script>
    $(function(){
        $("a[detalhes]").click(function(){
            detalhes = $(this).attr("detalhes");
            $.ajax({
                type:"POST",
                data:{
                    detalhes,
                },
                url:"financeira/clientes/logs.php",
                success:function(dados){
                    $.alert({
                        content:dados,
                        title:"Log",
                        type:"blue",
                        columnClass:"col-md-8"
                    })
                }
            })
        })
    })
</script>