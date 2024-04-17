<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function consulta_logs($dados){
        global $con;
        $sessoes = [
            'proposta' => $dados['proposta'],
            'codUsr' => $dados['codUsr'],
            'acao' => 'cron'
        ];
        mysqli_query($con, "update consultas_log set ativo = '0' where cliente = '{$dados['codUsr']}'");
        $query = "insert into consultas_log set 
                                            consulta = '{$dados['proposta']}',
                                            cliente = '{$dados['codUsr']}',
                                            data = NOW(),
                                            sessoes = '".json_encode($sessoes)."',
                                            log = '{$dados['consulta']}',
                                            log_unico = '".md5($dados['consulta'].$dados['proposta'])."',
                                            ativo = '1'";

        $result = mysqli_query($con, $query);
    }

    $vctex = new Vctex;

    $query = "select *, api_vctex_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

// print_r($d);

    $token = $d->token;
    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
            $token = $dados->token->accessToken;
            mysqli_query($con, "update configuracoes set api_vctex_expira = '".($agora + $dados->token->expires)."', api_vctex_dados = '{$retorno}', api_vctex_tabelas = '{$tabelas}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }


    $query = "select *, proposta->>'$.data.proposalId' as proposalId from consultas where proposta->>'$.statusCode' in ('200', '60', '110', '61', '95')";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result)){
        while($d = mysqli_fetch_object($result)){

            $consulta = $vctex->Conculta([
                'token' => $token,
                'proposalId' => $d->proposalId
            ]);
            $retorno = json_decode($consulta);
            $status_cod = $retorno->proposalStatusId;
            $status_msg = $retorno->proposalStatusDisplayTitle;

            $verifica = mysqli_num_rows(mysqli_query($con, "select * from consultas_log where log_unico = '".md5($consulta.$d->codigo)."'"));
            if(!$verifica){
            consulta_logs([
                'proposta' => $d->codigo,
                'consulta' => $consulta,
                'codUsr' => $d->cliente
            ]);
            }

            $query1 = "update `consultas` set 
                                            proposta = JSON_SET(proposta, '$.statusCode', '{$status_cod}'),
                                            proposta = JSON_SET(proposta, '$.message', '{$status_msg}')
                            where codigo = '{$d->codigo}'";

            $result1 = mysqli_query($con, $query1);

        }
    }