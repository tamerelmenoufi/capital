<?php

class Vctex {

    public $ambiente = 'homologacao'; //homologacao ou producao

    public function Ambiente($opc){
        if($opc == 'homologacao'){
            return 'https://fgts.sandbox.salaryfits.com.br/api/';
        }else{
            return 'https://appvctex.com.br/api/';
        }
    }

    public function Token(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'authentication/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "cpf":"99713047249",
            "password":"bpKqLXNKKLxy9gG"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }


    public function Tabelas($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'service/fee-schedule',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.$token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";

    }


    public function Simular($dados){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente).'service/simulation',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"clientCpf":"'.$dados['cpf'].'","feeScheduleId":'.$dados['tabela'].'}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$dados['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";
    }

    public function Credito($token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Ambiente($this->ambiente)."service/proposal",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "feeScheduleId": 1,
            "financialId": "443139a1-22e5-4c5c-a23f-46d17130eafe",
            "borrower": {
              "name": "Ayrton Sato",
              "cpf": "20006161278",
              "birthdate": "1991-07-26",
              "gender": "M",
              "phoneNumber": "11973302222",
              "email": "ayrton_sato@hotmail.com",
              "maritalStatus": "solteiro",
              "nationality": "brasileiro",
              "naturalness": "brasileiro",
              "motherName": "Maria Silva",
              "fatherName": "Joao Silva",
              "pep": false
            },
            "document": {
              "type": "cnh",
              "number": "12345555",
              "issuingState": "SP",
              "issuingAuthority": "SSP",
              "issueDate": "2022-01-01"
            },
            "address": {
              "zipCode": "03431120",
              "street": "Rua Juca",
              "number": "321",
              "complement": null,
              "neighborhood": "Casa",
              "city": "São Paulo",
              "state": "SP"
            },
            "disbursementBankAccount": {
              "bankCode": "652",
              "accountType": "corrente",
              "accountNumber": "173090",
              "accountDigit": "1",
              "branchNumber": "2"
            }
          }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$token
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."/orders/preview"."\n".$this->apiKey($this->ambiente)."\n";

    }

}