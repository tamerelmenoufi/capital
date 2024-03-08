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
            "password":"KG23gvwLD@"
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


    public function Simular($token){

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
        CURLOPT_POSTFIELDS =>'{
            clientCpf: "string",
            feeScheduleId: "number",
            targetDisbursedAmount: "number"
        }',
        CURLOPT_HTTPHEADER => array(
            // 'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response; //."\n".$this->Ambiente($this->ambiente)."\n".$this->apiKey($this->ambiente, $loja)."\n";
    }

    public function Crédito($token){

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
            feeScheduleId: "number", (int)
            financialId: "string",
            borrower: {
                name: "string",
                cpf: "string", (sem máscara)
                birthdate: "string", (formato AAAA-MM-DD)
                gender: "string",
                phoneNumber: "string", (número móvel, sem máscara e com ddd - "XX9XXXXXXXX")
                email: "string",
                maritalStatus: "string",
                nationality: "string",
                naturalness: "string" | "null",
                motherName: "string",
                fatherName: "string" | "null",
                pep: "boolean" (pessoa exposta politicamente)
            },
            document: {
                type: "string", ("cnh" ou "rg")
                number: "string", (sem máscara)
                issuingState: "string", (Ex: "CE", "SP", "RS" ...),
                issuingAuthority: "string",
                issueDate: "string" (formato AAAA-MM-DD)
            },
            address: {
                zipCode: "string", (sem máscara)
                street: "string",
                number: "string",
                complement: "string" | "null",
                neighborhood: "string",
                city: "string",
                state: "string", (Ex: "CE", "SP", "RS" ...)
            },
            disbursementBankAccount: {
                bankCode: "string",
                accountType: "string", ("corrente" ou "poupanca"),
                accountNumber: "string",
                accountDigit: "string",
                branchNumber: "string"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-token: '.$this->apiKey($this->ambiente),
            // 'x-integrator-token: '.$this->integradora($this->ambiente, $loja),
            'accept: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response; //."\n".$this->Ambiente($this->ambiente)."/orders/preview"."\n".$this->apiKey($this->ambiente)."\n";

    }

}