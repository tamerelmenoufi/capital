<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
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
    <div class="alert alert-primary" style="height:90px;">
        <b><?=$titulo?></b>
        <h2><?=$total?></h2>
    </div>
</div>
<?php
    }
?>
</div>

<canvas id="grafico" style="margin-top:30px;"></canvas>

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
                                responsive: true,
                                plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Chart.js Doughnut Chart'
                                }
                                }
                            },
                        };

        const chart = new Chart('grafico', config);


    })
</script>