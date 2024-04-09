<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/site/assets/lib/includes.php");

    $lista = file_get_contents("converter.csv");
    $linhas = explode("\n", $lista);

    function formatCpf($value)
    {
    $CPF_LENGTH = 11;
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    
        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 
    
    }

    function formatTelefone($value)
    {
    $TELEFONE_LENGTH = 11;
    $telefone = preg_replace("/\D/", '', $value);
    
        if (strlen($telefone) === $TELEFONE_LENGTH) {
            return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", $telefone);
        } 
    
    }
?>
<table width="100%" border="1">
    <tr>
        <td>#</td>
        <td>Nome</td>
        <td>CPF</td>
        <td>Telefone</td>
    </tr>
<?php
    $cnt = 1;
    $query = [];
    foreach($linhas as $i => $l){
        if($i > 0){
            $c = explode("	",$l);
        if( trim($c[0]) and formatCpf(trim($c[1])) and formatTelefone(trim($c[2])) ){

            $query[] = "('".trim($c[0])."', '".formatCpf(trim($c[1]))."', '2024-04-09 00:00:00', '2024-04-09 00:00:00', '".formatTelefone(trim($c[2]))."', '2024-04-09 00:00:00', '2024-04-09 00:00:00')";
?>            
    <tr>
        <td><?=$cnt?></td>
        <td><?=trim($c[0])?></td>
        <td><?=formatCpf(trim($c[1]))?></td>
        <td><?=formatTelefone(trim($c[2]))?></td>
    </tr>
<?php
    $cnt++;
        }
        }
    }

    echo $query = "INSERT INTO clientes (nome, cpf, data_cadastro, ultimo_acesso, phoneNumber, pre_cadastro, autorizacao_vctex) VALUES ".implode(", ",$query);


?>
</table>