<?php

class Facta {

    public $ambiente = 'homologacao'; //homologacao ou producao

    public function Ambiente($opc){
        if($opc == 'homologacao'){
            return 'https://webservice-homol.facta.com.br/';
        }else{
            return 'https://webservice.facta.com.br/';
        }
    }

    public function Token(){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->Ambiente($this->ambiente).'gera-token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Basic OTY3NTM6a2M4emRmZjljdWxoajFjbGpoZWQ=';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
       
    }

    public function Saldo($token = false){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->Ambiente($this->ambiente).'fgts/saldo?cpf=00000000000');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer yJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxNDAzIiwibHZsIjoiMiIsInVzciI6Ijk2NzUzIiwiY3J0IjoiOTY3NTMiLCJpYXQiOjE3MTA2ODY2OTYsImV4cCI6MTcxMDY5MDI5Nn0.X1MTKY9R5g3zitDr0t-8vOrRyFf_0dTVHsRPMNonHms';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;

    }


    public function Calculo($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'fgts/calculo',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "cpf": "00000000000",
            "taxa": 2.04,
            "tabela": 38601,
            "parcelas": [
              {
                "dataRepasse_1": "01/03/2022",
                "valor_1": 2059.05
              },
              {
                "dataRepasse_2": "01/03/2023",
                "valor_2": 1645.86
              },
              {
                "dataRepasse_3": "01/03/2024",
                "valor_3": 1152.10
              },
              {
                "dataRepasse_4": "01/03/2025",
                "valor_4": 806.47
              },
              {
                "dataRepasse_5": "01/03/2026",
                "valor_5": 564.53
              },
              {
                "dataRepasse_6": "01/03/2027",
                "valor_6": 376.90
              },
              {
                "dataRepasse_7": "01/03/2028",
                "valor_7": 220.18
              },
              {
                "dataRepasse_8": "01/03/2029",
                "valor_8": 0.00
              },
              {
                "dataRepasse_9": "01/03/2030",
                "valor_9": 0.00
              },
              {
                "dataRepasse_10": "01/03/2031",
                "valor_10": 0.00
              },
              {
                "dataRepasse_11": "01/03/2032",
                "valor_11": 0.00
              },
              {
                "dataRepasse_12": "01/03/2033",
                "valor_12": 0.00
              }
            ]
          }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }


    public function Simulador1($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'proposta/etapa1-simulador',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>array('produto' => 'D','tipo_operacao' => '13','averbador' =>
        '20095','convenio' => '3','cpf' => '00000000000','data_nascimento' => '00/00/0000',
        'login_certificado' => '0000_teste','simulacao_fgts' => '000000'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }




    public function DadosPessoais($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'proposta/etapa2-dados-pessoais',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
                                    'id_simulador' => '0000000',
                                    'cpf' => '00000000000',
                                    'nome' => 'Fulano de Tal',
                                    'sexo' => 'M',
                                    'estado_civil' => '6',
                                    'data_nascimento' => '01/01/2000',
                                    'rg' => '000000',
                                    'estado_rg' => 'RS',
                                    'data_expedicao' => '01/01/2000',
                                    'orgao_emissor' => 'SSP',
                                    'estado_natural' => 'RS',
                                    'cidade_natural' => '35',
                                    'nacionalidade' => '1',
                                    'celular' =>'(000) 00000-0000',
                                    'renda' => '1100',
                                    'cep' => '00000000',
                                    'endereco' => 'Rua A',
                                    'numero' => '1',
                                    'bairro' => 'Centro',
                                    'cidade' => '35',
                                    'estado' => 'RS',
                                    'nome_mae' => 'NAO DECLARADO',
                                    'nome_pai' => 'NAO DECLARADO',
                                    'valor_patrimonio' => '1',
                                    'cliente_iletrado_impossibilitado' => 'N',
                                    'banco' => '999',
                                    'agencia' => '9999',
                                    'conta' => '9999999'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }



    public function Cadastro($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'proposta/etapa3-proposta-cadastro',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('codigo_cliente' => 0000204,'id_simulador' => '0000765'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }

    public function Envio($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'proposta/envio-link',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('codigo_af' => 00005127,'tipo_envio' => 'whatsapp'), //whatsapp ou sms
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }

}