<?php


class wgw {

    public function key(){
        global $Conf;
        return $Conf['wgw-key'];
    }

    public function gravando($dados = false){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/SendChatStateRecording',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'apikey='.$this->key().'&phone_number=12046500801&contact_phone_number=5592991886570',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    
    public function pausaGravando($dados = false){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/SendChatStatePaused',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'apikey='.$this->key().'&phone_number=12046500801&contact_phone_number=5592991886570',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }    

    public function SendTxt($dados = false){

        gravando();

        sleep(10);

        pausaGravando();

        sleep(1);

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/Send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
        "apikey" : "'.$this->key().'",
        "phone_number" : "12046500801",
        "contact_phone_number" : "5592991886570",
        "message_custom_id" : "'.date("YmdHis").'",
        "message_type" : "text",
        "message_body" : "Teste de Msg\\n_Italico_ \\n*negrito*\\n~tachado~\\n```Monoespaçado```\\n😜"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;

    }
}