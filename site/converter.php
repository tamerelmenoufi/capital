<?php

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

    foreach($linhas as $i => $l){
        if($i > 0){
            $c = explode("	",$l);
            echo trim($c[0])."<br>".
            formatCpf(trim($c[1]))."<br>".
            formatTelefone(trim($c[2]))."<br>".
            "<hr>";
        }
    }

?>