<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function consulta_logs($dados){
        global $con;
        $query = "insert into `consultas_log` set 
                                            consulta = '{$dados['proposta']}',
                                            cliente = '{$dados['codUsr']}',
                                            data = NOW(),
                                            sessoes = '".json_encode($dados)."',
                                            log = '{$dados['consulta']}'";

        $result = mysqli_query($con, $query);
    }

    $vctex = new Vctex;


    $query = "select *, proposta->>'$.data.proposalId' as proposalId from consultas where proposta->>'$.statusCode' in ('200', '60')";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){

        $consulta = $vctex->Conculta([
            'token' => $token,
            'proposalId' => $d->proposalId
        ]);
        $retorno = json_decode($consulta);
        $status_cod = $retorno->proposalStatusId;
        $status_msg = $retorno->proposalStatusDisplayTitle;

        consulta_logs([
            'proposta' => $d->codigo,
            'consulta' => $consulta,
            'codUsr' => $d->cliente
        ]);

        $query = "update `consultas` set 
                                        proposta = JSON_SET(proposta, '$.statusCode', '{$status_cod}'),
                                        proposta = JSON_SET(proposta, '$.message', '{$status_msg}')
                        where codigo = '{$d->codigo}'";

        $result = mysqli_query($con, $query);

    }