<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    function numero($v){
        $remove = [" ","/","-",".","(",")"];
        return str_replace($remove, false, $v);
    }

    function consulta_logs($dados){
        global $con;
        mysqli_query($con, "update consultas_log set ativo = '0' where cliente = '{$dados['codUsr']}'");
        $query = "insert into consultas_log set 
                                            consulta = '{$dados['proposta']}',
                                            cliente = '{$dados['codUsr']}',
                                            data = NOW(),
                                            sessoes = '{\"codUsr\":\"{$dados['codUsr']}\"}',
                                            log = '{$dados['consulta']}',
                                            log_unico = '".md5($dados['consulta'].$dados['proposta'])."',
                                            ativo = '1'";

        $result = sisLog( $query);
    }

    $vctex = new Vctex;

    $query = "select *, api_vctex_dados->>'$.token.accessToken' as token from configuracoes where codigo = '1'";
    $result = sisLog( $query);
    $d = mysqli_fetch_object($result);

    $token = $d->token;
    $tabela_padrao = $d->api_vctex_tabela_padrao;

    $agora = time();

    if($agora > $d->api_expira){
        $retorno = $vctex->Token();
        $dados = json_decode($retorno);
        if($dados->statusCode == 200){
            $tabelas = $vctex->Tabelas($dados->token->accessToken);
            $token = $dados->token->accessToken;
            sisLog( "update configuracoes set api_vctex_expira = '".($agora + $dados->token->expires)."', api_vctex_dados = '{$retorno}', api_vctex_tabelas = '{$tabelas}' where codigo = '1'");
        }else{
            $tabelas = 'error';
        }
    }



        $query = "select * from clientes where simulacao_10 = '0' and cpf != '' limit 10";
        $result = sisLog( $query);
        while($d = mysqli_fetch_object($result)){
            set_time_limit(90);
            //$tabela_padrao = $tabela_padrao;
            $tabela_escolhida = $tabela_padrao;

            $simulacao = $vctex->Simular([
                'token' => $token,
                'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
                'tabela' => $tabela_padrao
            ]);
            
            $verifica = json_decode($simulacao);
            // var_dump($verifica);
            if($verifica->data->isExponentialFeeScheduleAvailable == true and $verifica->statusCode == 200){

                $simulacao = $vctex->Simular([
                    'token' => $token,
                    'cpf' => str_replace(['-',' ','.'],false,trim($d->cpf)),
                    'tabela' => 0
                ]);

                $tabela_padrao = 0;

            }


            $consulta = uniqid();

            $verifica = json_decode($simulacao);

            if($verifica->statusCode == 200){
                $wgw = new wgw;
                $wgw->SendTxt([
                    'de' => $ConfWappNumero,
                    'para' => '5592981490562',
                    'mensagem' => "Proposta gerada com sucesso para {$d->nome} - CPF: {$d->cpf}\nContato de telefone +55{$d->phoneNumber}"
                ]);

                $nome = explode(" ",trim($d->nome))[0];
                $valor = number_format($verifica->data->simulationData->totalReleasedAmount,2,',','.');
                $wgw->SendTxt([
                    'de' => $ConfWappNumero,
                    'para' => '55'.str_replace(['(',')',' ','-'],false,trim($d->phoneNumber)),
                    'mensagem' => "Olá {$nome}, seu FGTS atualizou, já pode antecipar R\${$valor}. Acesse capitalsolucoesam.com.br e solicite agora mesmo o seu saldo FGTS.\nSe preferir entre em contato com o nosso atendimento pelo WhatsApp +5592981490562\nÉ confiável, seguro e rápido.\nAguardamos seu contato.\n*Capital Soluções*"
                ]);

                $wgw->SendTxt([
                    'de' => $ConfWappNumero,
                    'para' => '5592981490562',
                    'mensagem' => "Olá {$nome}, seu FGTS atualizou, já pode antecipar R\${$valor}. Acesse capitalsolucoesam.com.br e solicite agora mesmo o seu saldo FGTS.\nSe preferir entre em contato com o nosso atendimento pelo WhatsApp +5592981490562\nÉ confiável, seguro e rápido.\nAguardamos seu contato.\n*Capital Soluções*"
                ]);  

            }
            
            // else{
            //     $wgw = new wgw;
            //     $wgw->SendTxt([
            //         'de' => $ConfWappNumero,
            //         'para' => '5592981490562',
            //         'mensagem' => "Proposta infelizmente não foi gerada para {$d->nome} - CPF: {$d->cpf}\nContato de telefone +55{$d->phoneNumber}"
            //     ]);            
            // }

            $query1 = "insert into consultas set 
                                                consulta = '{$consulta}',
                                                operadora = 'VCTEX',
                                                cliente = '{$d->codigo}',
                                                data = NOW(),
                                                tabela_escolhida = '{$tabela_escolhida}',
                                                tabela = '{$tabela_padrao}',
                                                dados = '{$simulacao}'
                                                ";
            mysqli_query($con, $query1);
            $proposta = mysqli_insert_id($con);
            $verifica = mysqli_num_rows(mysqli_query($con, "select * from consultas_log where log_unico = '".md5($simulacao.$proposta)."'"));
            if(!$verifica){
            consulta_logs([
                'proposta' => $proposta,
                'consulta' => $simulacao,
                'codUsr' => $d->codigo
            ]);
            }

            mysqli_query($con, "update clientes set simulacao_10 = '1' where codigo = '{$d->codigo}'");
        }
        // exit();




?>
