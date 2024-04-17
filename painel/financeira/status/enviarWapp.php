<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

        $query = "select * from status_mensagens where codigo = '{$_POST['envio']}'";
        $result = mysqli_query($con, $query);
        $d = mysqli_fetch_object($result);

        $dadosParaEnviar = http_build_query(
            array(
                'numeros' => [559291886570],
                'mensagem' => (($d->mensagem)?:''),
                'instancia' => 2,
                'tipo' => (($d->tipo)?:''), //img, arq
                'arquivo' => (($d->arquivo)?"https://painel.capitalsolucoesam.com.br/volume/wapp/status/{$d->status}/{$d->arquivo}":'') //URL ou Bse64
            )
        );
        $opcoes = array('http' =>
               array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $dadosParaEnviar
            )
        );

        $contexto = stream_context_create($opcoes);
        echo $result   = file_get_contents('http://wapp.mohatron.com/tme.php', false, $contexto);

?>