<?php
//verificação da autorização
if($d->autorizacao_vctex > 0){
?>
    $(`i[etapa="fgts/home.php"], div[etapa="fgts/home.php"]`).attr("acao", "lib");
    $(`i[etapa="fgts/autorizacao.php"], div[etapa="fgts/autorizacao.php"]`).attr("acao", "lib");
    $(".linha").css("width","25%");
    $(`i[etapa="fgts/autorizacao.php"]`).removeClass("fa-regular");
    $(`i[etapa="fgts/autorizacao.php"]`).addClass("fa-solid");
    $(`i[etapa="fgts/home.php"]`).removeClass("fa-regular");
    $(`i[etapa="fgts/home.php"]`).addClass("fa-solid");
<?php
}else{
?>
    $(`i[etapa="fgts/home.php"], div[etapa="fgts/home.php"]`).attr("acao", "blq");
    $(`i[etapa="fgts/autorizacao.php"], div[etapa="fgts/autorizacao.php"]`).attr("acao", "blq");
    $(".linha").css("width","0%");
    $(`i[etapa="fgts/autorizacao.php"]`).removeClass("fa-solid");
    $(`i[etapa="fgts/autorizacao.php"]`).addClass("fa-regular");
    $(`i[etapa="fgts/home.php"]`).removeClass("fa-solid");
    $(`i[etapa="fgts/home.php"]`).addClass("fa-regular");
<?php
}

//verificação do pré-cadastro
if($d->pre_cadastro > 0){
?>
    $(`i[etapa="fgts/saldo.php"], div[etapa="fgts/saldo.php"]`).attr("acao", "lib");
    $(`i[etapa="fgts/saldo.php"]`).removeClass("fa-regular");
    $(`i[etapa="fgts/saldo.php"]`).addClass("fa-solid");

    $(`i[etapa="fgts/cadastro.php"], div[etapa="fgts/cadastro.php"]`).attr("acao", "lib");
    $(".linha").css("width","75%");
    $(`i[etapa="fgts/cadastro.php"]`).removeClass("fa-regular");
    $(`i[etapa="fgts/cadastro.php"]`).addClass("fa-solid");

<?php
}else{
?>
    $(`i[etapa="fgts/saldo.php"], div[etapa="fgts/saldo.php"]`).attr("acao", "blq");
    $(".linha").css("width","25%");
    $(`i[etapa="fgts/saldo.php"]`).removeClass("fa-solid");
    $(`i[etapa="fgts/saldo.php"]`).addClass("fa-regular");

    $(`i[etapa="fgts/cadastro.php"], div[etapa="fgts/cadastro.php"]`).attr("acao", "blq");
    $(`i[etapa="fgts/cadastro.php"]`).removeClass("fa-solid");
    $(`i[etapa="fgts/cadastro.php"]`).addClass("fa-regular");

<?php
}

//verificação da autorização
if($d->cadastro_percentual == 100){
?>
    $(`i[etapa="fgts/consulta.php"], div[etapa="fgts/consulta.php"]`).attr("acao", "lib");
    $(".linha").css("width","100%");
    $(`i[etapa="fgts/consulta.php"]`).removeClass("fa-regular");
    $(`i[etapa="fgts/consulta.php"]`).addClass("fa-solid");
<?php
}else{
?>
    $(`i[etapa="fgts/consulta.php"], div[etapa="fgts/consulta.php"]`).attr("acao", "blq");
    $(".linha").css("width","75%");
    $(`i[etapa="fgts/consulta.php"]`).removeClass("fa-solid");
    $(`i[etapa="fgts/consulta.php"]`).addClass("fa-regular");
<?php
}

?>