<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .grafico{
        margin-bottom:10px;
    }
</style>
<div class="row g-0">
    <div class="m-3"></div>
<?php

    $placas = [
        'banners' => 'Banners',
        'servicos' => 'Produtos',
        'time' => 'Time da empresa',
        'depoimentos' => 'Depoimentos',
    ];

    foreach($placas as $tabela => $titulo){
        $r = mysqli_query($con, "select count(*) as qt, situacao from {$tabela} group by situacao");
        $total = $bloqueado = $liberado = 0;
        while($p = mysqli_fetch_object($r)){
            $total += $p->qt;
            if($p->situacao != 1) $bloqueado += $p->qt;
            else $liberado += $p->qt;
        }

?> 
<div class="col p-3">
    <div class="alert alert-primary" style="height:140px;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-fill">
                <b><?=$titulo?></b>
                <h2><?=$total?></h2>        
            </div>
            <canvas 
                    class="grafico"
                    height="100"
                    width="100"
                    bloqueado="<?=$bloqueado?>"
                    liberado="<?=$liberado?>"
                    total="<?=$total?>"
            ></canvas>        
        </div>
    </div>
</div>
<?php
    }
?>
</div>



<script>
    $(function(){

        Carregando('none');

        $(".grafico").each(function(){

            const obj = $(this);
            const bloqueado = obj.attr("bloqueado");
            const liberado = obj.attr("liberado");

            const data = {
            labels: ['Bloqueado', 'Liberado'],
            datasets: [
                {
                label: 'Publicações',
                data: [bloqueado,liberado],
                backgroundColor: ['Red', 'Green'],
                }
            ]
            };

            const config = {
            type: 'doughnut',
            data: data,
            options: {
                    responsive: false,
                    plugins: {
                    // legend: {
                    //     position: 'top',
                    // },
                    legend:false,
                    title:false,
                    // title: {
                    //     display: true,
                    //     text: 'Chart.js Doughnut Chart'
                    // }
                    }
                },
            };

            const chart = new Chart(obj, config);
        })
        


    })
</script>