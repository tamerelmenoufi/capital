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
        $total = $bloqueado = $liberado;
        while($p = mysqli_fetch_object($r)){
            $total += $p->qt;
            if($p->situacao != 1) $bloqueado += $p->qt;
            else $liberado += $p->qt;
        }

?> 
<div class="col p-3">
    <div class="alert alert-primary" style="height:140px;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-fill" style="border:solid 1px red">
                <b><?=$titulo?></b>
                <h2><?=$total?></h2>        
            </div>
            <canvas class="grafico" height="100" width="100" style="border:solid 1px green"></canvas>        
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

        const data = {
        labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
        datasets: [
            {
            label: 'Dataset 1',
            data: [10,20,24,11,33],
            backgroundColor: ['Red', 'Orange', 'Yellow', 'Green', 'Blue'],
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

        $(".grafico").each(function(){
            const chart = new Chart($(this), config);
        })
        


    })
</script>