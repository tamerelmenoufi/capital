<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

?>
<style>
    .calendario td{
        font-size:12px;
        text-align:center;
        min-height:25px;
        padding:5px;
    }

    .calendario th{
        font-size:12px;
        text-align:center;
        min-height:25px;
        padding:5px;
    }
</style>
<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira</h5>
  <div class="card-body">
    <h5 class="card-title">Relatórios e estatísticas</h5>
    <p class="card-text">Tela de exibição das informações de consultas, contratos e histórico dos clientes.</p>
    <p class="card-text">Em desenvolvimento. Disponibilidade em breve.</p>
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->

    <?php
    


    // Configurações iniciais
    $month = date("n");
    $year = date("Y");
    $first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
    $end_day_of_month = mktime(0, 0, 0, $month + 1, 1-1, $year);
    $days_in_month = (((($end_day_of_month)/84600) - (($first_day_of_month)/84600)) + 1);

    $day_of_week = date("N", $first_day_of_month);
    $month_name = date("F", $first_day_of_month);

    $dados = [];
    $query = "select a.codigo as cod_cliente, a.nome, a.cpf, b.log, b.codigo from consultas_log b left join clientes a on a.codigo = b.cliente where a.ultimo_acesso like '2024-03%' order by b.codigo asc";
    $result = mysqli_query($con,$query);
    while($d = mysqli_fetch_object($result)){
        $dt = trim(explode(" ", $d->ultimo_acesso)[0]);
        $dados[$dt][$d->cod_cliente]['log'] = $d->log;
    }

    var_dump($dados);

    // Cabeçalho do calendário
    echo "<h2>Calendário de $month_name $year</h2>";
    echo "<table border='1' class='calendario'>";
    echo "<tr><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th><th>Dom</th></tr>";

    // Calcular espaços em branco para os dias do mês anterior
    $blank_spaces = $day_of_week - 1;

    // Calcular o número total de células na tabela
    $total_cells = $blank_spaces + $days_in_month;

    // Contador de dias
    $day_counter = 1;

    // Loop para construir a tabela
    for ($i = 0; $i < 6; $i++) {
        echo "<tr>";
        for ($j = 0; $j < 7; $j++) {
            if ($blank_spaces > 0) {
                echo "<td></td>";
                $blank_spaces--;
            } elseif ($day_counter <= $days_in_month) {
                $tem = count($dados["2024-03-".str_pad($day_counter, 2, "0", STR_PAD_LEFT)]);
                echo "<td>{$day_counter}"."<br>".$tem."</td>";
                $day_counter++;
            }
        }
        echo "</tr>";
    }

    echo "</table>";

    ?>


  </div>
</div>


<script>
    $(function(){

        Carregando('none');


    })
</script>