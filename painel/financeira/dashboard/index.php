<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

?>

<div class="card m-3">
  <h5 class="card-header">Sistema Capital Financeira</h5>
  <div class="card-body">
    <h5 class="card-title">Relatórios e estatísticas</h5>
    <p class="card-text">Tela de exibição das informações de consultas, contratos e histórico dos clientes.</p>
    <p class="card-text">Em desenvolvimento. Disponibilidade em breve.</p>
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->

    <?php
    $query = "select * from consultas_log ";


    // Configurações iniciais
    $month = date("n");
    $year = date("Y");
    $first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
    $end_day_of_month = mktime(0, 0, 0, $month + 1, 1-1, $year);
    echo $days_in_month = ((($end_day_of_month)/84600) - (($first_day_of_month)/84600));

    $day_of_week = date("N", $first_day_of_month);
    $month_name = date("F", $first_day_of_month);

    // Cabeçalho do calendário
    echo "<h2>Calendário de $month_name $year</h2>";
    echo "<table border='1'>";
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
                echo "<td>$day_counter</td>";
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