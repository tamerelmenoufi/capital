<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    $query = "select * from configuracoes where codigo = '1'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>

<style>
    /* .bg-poup{
        background:#000;
    }
   
    .jconfirm .jconfirm-box {
  background: #09a5da;
  border-radius: 4px;
  position: relative;
  outline: none;
  padding: 15px 15px 0;
  overflow: hidden;
  margin-left: auto;
  margin-right: auto;
} */
</style>   
<div class="col-md-12">
    <?=$d->direitos?>
</div>