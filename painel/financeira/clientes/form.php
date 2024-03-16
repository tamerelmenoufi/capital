<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

        $siglas = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];

    if($_POST['acao'] == 'salvar'){

        $data = $_POST;
        $attr = [];

        unset($data['codigo']);
        unset($data['acao']);
        unset($data['senha']);

        foreach ($data as $name => $value) {
            if($name == 'birthdate' or $name == 'document_issueDate'){
                $attr[] = "{$name} = '" . dataMysql($value) . "'";
            }else{
                $attr[] = "{$name} = '" . addslashes($value) . "'";
            }
            
        }

        $attr = implode(', ', $attr);

        if($_POST['codigo']){
            $query = "update clientes set {$attr} where codigo = '{$_POST['codigo']}'";
            mysqli_query($con, $query);
            $cod = $_POST['codigo'];
        }else{
            $query = "insert into clientes set data_cadastro = NOW(), {$attr}";
            mysqli_query($con, $query);
            $cod = mysqli_insert_id($con);
        }

        $retorno = [
            'status' => true,
            'codigo' => $cod
        ];

        echo json_encode($retorno);

        exit();
    }

    $query = "select * from clientes where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>">Cadastro do Usuário</h4>
    <form id="form-<?= $md5 ?>">
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input required type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" value="<?=$d->nome?>">
                    <label for="nome">Nome*</label>
                </div>
                <div class="form-floating mb-3">
                    <input required type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" value="<?=(($_POST['cpf'])?:$d->cpf)?>">
                    <label for="cpf">CPF*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="birthdate" id="birthdate" class="form-control" placeholder="birthdate" value="<?=dataBr($d->birthdate)?>">
                    <label for="birthdate">birthdate*</label>
                </div>


                <div class="form-floating mb-3">
                    <select name="gender" id="gender" class="form-select">
                        <option value="M" <?=(($d->gender == 'M')?'selected':false)?>>Masculino</option>
                        <option value="F" <?=(($d->gender == 'F')?'selected':false)?>>Feminino</option>
                    </select>
                    <label for="gender">gender*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="phoneNumber" value="<?=dataBr(trim($d->phoneNumber))?>">
                    <label for="phoneNumber">phoneNumber*</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="email" value="<?=$d->email?>">
                    <label for="email">email</label>
                </div>


                <div class="form-floating mb-3">
                    <select name="maritalStatus" id="maritalStatus" class="form-select">
                        <option value="Solteiro" <?=(($d->maritalStatus == 'Solteiro')?'selected':false)?>>Solteiro</option>
                        <option value="Casado" <?=(($d->maritalStatus == 'Casado')?'selected':false)?>>Casado</option>
                        <option value="Divorciado" <?=(($d->maritalStatus == 'Divorciado')?'selected':false)?>>Divorciado</option>
                        <option value="Separado" <?=(($d->maritalStatus == 'Separado')?'selected':false)?>>Separado</option>
                        <option value="Viúvo" <?=(($d->maritalStatus == 'Viúvo')?'selected':false)?>>Viúvo</option>
                    </select>
                    <label for="maritalStatus">maritalStatus*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="nationality" id="nationality" class="form-control" placeholder="nationality" value="<?=$d->nationality?>">
                    <label for="nationality">nationality*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="naturalness" id="naturalness" class="form-control" placeholder="naturalness" value="<?=$d->naturalness?>">
                    <label for="naturalness">naturalness*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="motherName" id="motherName" class="form-control" placeholder="motherName" value="<?=$d->motherName?>">
                    <label for="motherName">motherName*</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="text" name="fatherName" id="fatherName" class="form-control" placeholder="fatherName" value="<?=$d->fatherName?>">
                    <label for="fatherName">fatherName</label>
                </div>


                <div class="form-floating mb-3">
                    <select name="pep" id="pep" class="form-select">
                        <option value="false" <?=(($d->pep == 'false')?'selected':false)?>>Não</option>
                        <option value="true" <?=(($d->pep == 'true')?'selected':false)?>>Sim</option>
                    </select>
                    <label for="pep">pep*</label>
                </div>

                <h5>Documentação</h5>
                <div class="form-floating mb-3">
                    <select name="document_type" id="document_type" class="form-select">
                        <option value="RG" <?=(($d->document_type == 'RG')?'selected':false)?>>RG</option>
                        <option value="CNH" <?=(($d->document_type == 'CNH')?'selected':false)?>>CNH</option>
                    </select>
                    <label for="document_type">document_type*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="document_number" id="document_number" class="form-control" placeholder="document_number" value="<?=$d->document_number?>">
                    <label for="document_number">document_number*</label>
                </div>


                <div class="form-floating mb-3">
                    <select required name="document_issuingState" id="document_issuingState" class="form-select">
                        <option value="">:: Selecione o estado ::</option>
                        <?php
                        foreach($siglas as $i => $sigla){
                        ?>
                        <option value="<?=$sigla?>" <?=(($d->document_issuingState == $sigla)?'selected':false)?>><?=$sigla?></option>
                        <?php
                        }
                        ?>
                    </select>    
                    <label for="document_issuingState">document_issuingState*</label>


                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="document_issuingAuthority" id="document_issuingAuthority" class="form-control" placeholder="document_issuingAuthority" value="<?=$d->document_issuingAuthority?>">
                    <label for="document_issuingAuthority">document_issuingAuthority*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="document_issueDate" id="document_issueDate" class="form-control" placeholder="document_issueDate" value="<?=dataBr(trim($d->document_issueDate))?>">
                    <label for="document_issueDate">document_issueDate*</label>
                </div>

                <h5>Endereço</h5>

                <div class="form-floating mb-3">
                    <input required type="text" name="address_zipCode" id="address_zipCode" class="form-control" placeholder="address_zipCode" value="<?=$d->address_zipCode?>">
                    <label for="address_zipCode">address_zipCode*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="address_street" id="address_street" class="form-control" placeholder="address_street" value="<?=$d->address_street?>">
                    <label for="address_street">address_street*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="address_number" id="address_number" class="form-control" placeholder="address_number" value="<?=$d->address_number?>">
                    <label for="address_number">address_number*</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="text" name="address_complement" id="address_complement" class="form-control" placeholder="address_complement" value="<?=$d->address_complement?>">
                    <label for="address_complement">address_complement</label>
                </div>


                <div class="form-floating mb-3">
                    <input type="text" name="address_neighborhood" id="address_neighborhood" class="form-control" placeholder="address_neighborhood" value="<?=$d->address_neighborhood?>">
                    <label for="address_neighborhood">address_neighborhood</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="address_city" id="address_city" class="form-control" placeholder="address_city" value="<?=$d->address_city?>">
                    <label for="address_city">address_city*</label>
                </div>


                <div class="form-floating mb-3">
                    <select required name="address_state" id="address_state" class="form-select">
                        <option value="">:: Selecione o Estado ::</option>
                        <?php
                        foreach($siglas as $i => $sigla){
                        ?>
                        <option value="<?=$sigla?>" <?=(($d->address_state == $sigla)?'selected':false)?>><?=$sigla?></option>
                        <?php
                        }
                        ?>
                    </select>   
                    <label for="address_state">address_state*</label>
                </div>

                <h5>Dados Bancários</h5>

                <div class="form-floating mb-3">
                    <input required type="text" name="bankCode" id="bankCode" class="form-control" placeholder="bankCode" value="<?=$d->bankCode?>">
                    <label for="bankCode">bankCode*</label>
                </div>


                <div class="form-floating mb-3">
                    <select name="accountType" id="accountType" class="form-select">
                        <option value="corrente" <?=(($d->accountType == 'corrente')?'selected':false)?>>Corrente</option>
                        <option value="poupanca" <?=(($d->accountType == 'poupanca')?'selected':false)?>>Poupança</option>
                    </select>
                    <label for="accountType">accountType*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="accountNumber" id="accountNumber" class="form-control" placeholder="accountNumber" value="<?=$d->accountNumber?>">
                    <label for="accountNumber">accountNumber*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="accountDigit" id="accountDigit" class="form-control" placeholder="accountDigit" value="<?=$d->accountDigit?>">
                    <label for="accountDigit">accountDigit*</label>
                </div>


                <div class="form-floating mb-3">
                    <input required type="text" name="branchNumber" id="branchNumber" class="form-control" placeholder="branchNumber" value="<?=$d->branchNumber?>">
                    <label for="branchNumber">branchNumber*</label>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col">
                <div style="display:flex; justify-content:end">
                    <button type="submit" class="btn btn-success btn-ms">Salvar</button>
                    <input type="hidden" id="codigo" value="<?=$_POST['cod']?>" />
                    <input type="hidden" id="retorno" value="<?=($_POST['retorno']?:'financeira/clientes/index.php')?>" />
                </div>
            </div>
        </div>
    </form>

    <script>
        $(function(){
            Carregando('none');

            $("#cpf").mask("999.999.999-99");
            $("#phoneNumber").mask("(99) 99999-9999");
            $("#birthdate, #document_issueDate").mask("99/99/9999");
            $("#address_zipCode").mask("99999-999");


            $('#form-<?=$md5?>').submit(function (e) {

                e.preventDefault();

                var codigo = $('#codigo').val();
                var retorno = $('#retorno').val();
                var campos = $(this).serializeArray();

                if (codigo) {
                    campos.push({name: 'codigo', value: codigo})
                }

                campos.push({name: 'acao', value: 'salvar'})

                cpf = $("#cpf").val();
                if(!validarCPF(cpf)){
                    $.alert({
                        title:"Erro",
                        content:"CPF Inválido",
                        type:'red'
                    });
                    return false;
                }

                Carregando();

                $.ajax({
                    url:"financeira/clientes/form.php",
                    type:"POST",
                    typeData:"JSON",
                    mimeType: 'multipart/form-data',
                    data: campos,
                    success:function(dados){
                        // console.log(dados)
                        // if(dados.status){
                            $.ajax({
                                url:retorno,
                                type:"POST",
                                success:function(dados){
                                    $("#paginaHome").html(dados);
                                    let myOffCanvas = document.getElementById('offcanvasDireita');
                                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                                    openedCanvas.hide();
                                }
                            });
                        // }
                    },
                    error:function(erro){

                        // $.alert('Ocorreu um erro!' + erro.toString());
                        //dados de teste
                    }
                });

            });

        })
    </script>