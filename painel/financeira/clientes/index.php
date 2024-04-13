<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['delete']){
      $query = "delete from clientes where codigo = '{$_POST['delete']}'";
      mysqli_query($con, $query);
    }

    if($_POST['situacao']){
      $query = "update clientes set situacao = '{$_POST['opc']}' where codigo = '{$_POST['situacao']}'";
      mysqli_query($con, $query);
      exit();
    }
?>
<style>
  .legenda_status{
    border-left:5px solid;
    border-left-color:green;
  }
</style>
<div class="col">
  <div class="m-3">

    <div class="row">
      <div class="col">
        <div class="card">
          <h5 class="card-header">Lista de Clientes</h5>


          <div class="card-body">

          <div class="row">
            <div class="col-md-8">
            <?php
            if($_SESSION['ProjectPainel']->codigo == 2){
            ?>
            <div class="input-group">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" campo="<?=(($_SESSION['busca_campo'])?:'cpf')?>" titulo="<?=(($_SESSION['busca_titulo'])?:'CPF')?>"><?=(($_SESSION['busca_titulo'])?:'CPF')?></button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" campo="cpf">CPF</a></li>
                <li><a class="dropdown-item" href="#" campo="nome">Nome</a></li>
                <li><a class="dropdown-item" href="#" campo="status">Situação</a></li>
              </ul>
              <input texto_busca type="text" class="form-control" <?=(($_SESSION['busca_campo'] == 'status')?'style="display:none"':false)?>>
              <select texto_busca class="form-select" <?=(($_SESSION['busca_campo'] != 'status')?'style="display:none"':false)?>>
                <option value="1">Teste 1</option>
                <option value="2">Teste 2</option>
                <option value="3">Teste 3</option>
                <option value="4">Teste 4</option>
                <option value="5">Teste 5</option>
              </select>
            </div>
            <?php
            }
            ?>            
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">CPF</span>
                <input type="text" class="form-control" id="cpf_novo">
                <button
                    novoCadastro
                    class="btn btn-success"
                    data-bs-toggle="offcanvas"
                    href="#offcanvasDireita"
                    role="button"
                    aria-controls="offcanvasDireita"
                >Novo</button>                
              </div>
            </div>

            </div>

            <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nome</th>
                  <th scope="col">CPF</th>
                  <th scope="col">Telefone</th>
                  <!-- <th scope="col">Nome da Mãe</th> -->
                  <th scope="col">Data de Cadastro</th>
                  <th scope="col">Situação</th>
                  <!-- <th scope="col">Situação</th> -->
                  <th style="width:250px;">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = "select a.*, (select log from consultas_log where cliente = a.codigo order by codigo desc limit 1) as log from clientes a order by a.data_cadastro desc";
                  $result = mysqli_query($con, $query);
                  $k = 1;
                  while($d = mysqli_fetch_object($result)){

                    $log = json_decode($d->log);
                    $del = 'disabled';
                    if($log->statusCode){
                      $situacao = "{$log->statusCode} - {$log->message}";
                      $cor="orange";
                    }else if($log->proposalStatusId){
                      $situacao = "{$log->proposalStatusId} - {$log->proposalStatusDisplayTitle}";
                      if($log->proposalStatusId == 130){
                        $cor="green";
                      }else{
                        $cor="red";
                      }
                    }else{
                      $situacao = "000 - Cliente sem movimentação";
                      $cor="#ccc";
                      $del = false;
                    }

                ?>
                <tr>
                  <td><?=$k?></td>
                  <td><?=$d->nome?></td>
                  <td><?=$d->cpf?></td>
                  <td><?=$d->phoneNumber?></td>
                  <!-- <td><?=$d->motherName?></td> -->
                  <td><?=dataBr($d->data_cadastro)?></td>
                  <td class="legenda_status" style="border-left-color:<?=$cor?>;">
                    <?=$situacao?>
                  </td>
                  <!-- <td>

                  <div class="form-check form-switch">
                    <input class="form-check-input situacao" type="checkbox" <?=(($d->codigo == 1)?'disabled':false)?> <?=(($d->situacao)?'checked':false)?> usuario="<?=$d->codigo?>">
                  </div>

                  </td> -->
                  <td>

                    <button vctex="<?=$d->cpf?>" class="btn btn-warning">
                      VCTEX
                    </button>
                    <!-- <button facta="<?=$d->cpf?>" class="btn btn-warning">
                      FACTA
                    </button> -->

                    <button
                      class="btn btn-primary"
                      style="margin-bottom:1px"
                      edit="<?=$d->codigo?>"
                      data-bs-toggle="offcanvas"
                      href="#offcanvasDireita"
                      role="button"
                      aria-controls="offcanvasDireita"
                    >
                      Editar
                    </button>
                    <button class="btn btn-danger" delete="<?=$d->codigo?>" <?=$del?>>
                      Excluir
                    </button>
                  </td>
                </tr>
                <?php
                $k++;
                  }
                ?>
              </tbody>
            </table>
                </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


<script>
    $(function(){
        Carregando('none');

        $("#cpf_novo, input[texto_busca]").mask("999.999.999-99");

        $("a[campo]").click(function(){
          campo = $(this).attr("campo");
          titulo = $(this).text();

          $("input[texto_busca]").val('');
          $("select[texto_busca]").val('');

          $("input[texto_busca]").unmask();

          $("button[campo]").attr("campo", campo);
          $("button[titulo]").attr("titulo", titulo);
          $("button[titulo]").text(titulo);

          if(campo != 'status'){

            $("input[texto_busca]").css("display", "block");
            $("select[texto_busca]").css("display", "none");

            
            if(campo == 'cpf'){
              $("input[texto_busca]").mask("999.999.999-99");
            }


          }else{
            $("input[texto_busca]").css("display", "none");
            $("select[texto_busca]").css("display", "block");
          }

        })

        $("button[novoCadastro]").click(function(){
            cpf = $("#cpf_novo").val();
            if(!cpf){
              let myOffCanvas = document.getElementById('offcanvasDireita');
              let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
              openedCanvas.hide();
              $.alert({
                content:"Favor informe o número do CPF",
                title:"Identificação do Cadastro",
                type:'red'
              })
              return false;
            }

            if(cpf.length != 14 || !validarCPF(cpf)){
              let myOffCanvas = document.getElementById('offcanvasDireita');
              let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
              openedCanvas.hide();
              $.alert({
                content:"Número de CPF informado inválido",
                title:"Erro de CPF",
                type:'red'
              })
              return false;              
            }

            $.ajax({
                url:"financeira/clientes/form.php",
                type:"POST",
                data:{
                  cpf_novo:cpf
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[vctex]").click(function(){
            valor = $(this).attr("vctex");
            $.ajax({
                url:"financeira/vctex/consulta.php",
                type:"POST",
                data:{
                  acao:'consulta',
                  campo:'cpf',
                  rotulo:"CPF",
                  valor
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })

        $("button[facta]").click(function(){
            valor = $(this).attr("facta");
            $.ajax({
                url:"financeira/facta/consulta.php",
                type:"POST",
                data:{
                  acao:'consulta',
                  campo:'cpf',
                  rotulo:"CPF",
                  valor
                },
                success:function(dados){
                    $("#paginaHome").html(dados);
                }
            })
        })

        $("button[edit]").click(function(){
            cod = $(this).attr("edit");
            $.ajax({
                url:"financeira/clientes/form.php",
                type:"POST",
                data:{
                  cod
                },
                success:function(dados){
                    $(".LateralDireita").html(dados);
                }
            })
        })

        $("button[delete]").click(function(){
            deletar = $(this).attr("delete");
            $.confirm({
                content:"Deseja realmente excluir o cadastro ?",
                title:false,
                buttons:{
                    'SIM':function(){
                        $.ajax({
                            url:"financeira/clientes/index.php",
                            type:"POST",
                            data:{
                                delete:deletar
                            },
                            success:function(dados){
                              // $.alert(dados);
                              $("#paginaHome").html(dados);
                            }
                        })
                    },
                    'NÃO':function(){

                    }
                }
            });

        })


        $(".situacao").change(function(){

            situacao = $(this).attr("usuario");
            opc = false;

            if($(this).prop("checked") == true){
              opc = '1';
            }else{
              opc = '0';
            }


            $.ajax({
                url:"financeira/clientes/index.php",
                type:"POST",
                data:{
                    situacao,
                    opc
                },
                success:function(dados){
                    // $("#paginaHome").html(dados);
                }
            })

        });

    })
</script>