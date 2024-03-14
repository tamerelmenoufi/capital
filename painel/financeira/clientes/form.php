<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['acao'] == 'salvar'){

        $data = $_POST;
        $attr = [];

        unset($data['codigo']);
        unset($data['acao']);
        unset($data['senha']);

        foreach ($data as $name => $value) {
            $attr[] = "{$name} = '" . addslashes($value) . "'";
        }
        if($_POST['senha']){
            $attr[] = "senha = '" . md5($_POST['senha']) . "'";
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
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" value="<?=$d->nome?>">
                    <label for="nome">Nome*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" value="<?=$d->cpf?>">
                    <label for="cpf">CPF*</label>
                </div>


<div class="form-floating mb-3">
    <input type="text" name="birthdate" id="birthdate" class="form-control" placeholder="birthdate" value="<?=$d->birthdate?>">
    <label for="birthdate">birthdate*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="gender" id="gender" class="form-control" placeholder="gender" value="<?=$d->gender?>">
    <label for="gender">gender*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="phoneNumber" value="<?=$d->phoneNumber?>">
    <label for="phoneNumber">phoneNumber*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="email" id="email" class="form-control" placeholder="email" value="<?=$d->email?>">
    <label for="email">email*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="maritalStatus" id="maritalStatus" class="form-control" placeholder="maritalStatus" value="<?=$d->maritalStatus?>">
    <label for="maritalStatus">maritalStatus*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="nationality" id="nationality" class="form-control" placeholder="nationality" value="<?=$d->nationality?>">
    <label for="nationality">nationality*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="naturalness" id="naturalness" class="form-control" placeholder="naturalness" value="<?=$d->naturalness?>">
    <label for="naturalness">naturalness*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="motherName" id="motherName" class="form-control" placeholder="motherName" value="<?=$d->motherName?>">
    <label for="motherName">motherName*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="fatherName" id="fatherName" class="form-control" placeholder="fatherName" value="<?=$d->fatherName?>">
    <label for="fatherName">fatherName*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="pep" id="pep" class="form-control" placeholder="pep" value="<?=$d->pep?>">
    <label for="pep">pep*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="document_type" id="document_type" class="form-control" placeholder="document_type" value="<?=$d->document_type?>">
    <label for="document_type">document_type*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="document_number" id="document_number" class="form-control" placeholder="document_number" value="<?=$d->document_number?>">
    <label for="document_number">document_number*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="document_issuingState" id="document_issuingState" class="form-control" placeholder="document_issuingState" value="<?=$d->document_issuingState?>">
    <label for="document_issuingState">document_issuingState*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="document_issuingAuthority" id="document_issuingAuthority" class="form-control" placeholder="document_issuingAuthority" value="<?=$d->document_issuingAuthority?>">
    <label for="document_issuingAuthority">document_issuingAuthority*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="document_issueDate" id="document_issueDate" class="form-control" placeholder="document_issueDate" value="<?=$d->document_issueDate?>">
    <label for="document_issueDate">document_issueDate*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_zipCode" id="address_zipCode" class="form-control" placeholder="address_zipCode" value="<?=$d->address_zipCode?>">
    <label for="address_zipCode">address_zipCode*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_street" id="address_street" class="form-control" placeholder="address_street" value="<?=$d->address_street?>">
    <label for="address_street">address_street*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_number" id="address_number" class="form-control" placeholder="address_number" value="<?=$d->address_number?>">
    <label for="address_number">address_number*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_complement" id="address_complement" class="form-control" placeholder="address_complement" value="<?=$d->address_complement?>">
    <label for="address_complement">address_complement*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_neighborhood" id="address_neighborhood" class="form-control" placeholder="address_neighborhood" value="<?=$d->address_neighborhood?>">
    <label for="address_neighborhood">address_neighborhood*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_city" id="address_city" class="form-control" placeholder="address_city" value="<?=$d->address_city?>">
    <label for="address_city">address_city*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="address_state" id="address_state" class="form-control" placeholder="address_state" value="<?=$d->address_state?>">
    <label for="address_state">address_state*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="bankCode" id="bankCode" class="form-control" placeholder="bankCode" value="<?=$d->bankCode?>">
    <label for="bankCode">bankCode*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="accountType" id="accountType" class="form-control" placeholder="accountType" value="<?=$d->accountType?>">
    <label for="accountType">accountType*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="accountNumber" id="accountNumber" class="form-control" placeholder="accountNumber" value="<?=$d->accountNumber?>">
    <label for="accountNumber">accountNumber*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="accountDigit" id="accountDigit" class="form-control" placeholder="accountDigit" value="<?=$d->accountDigit?>">
    <label for="accountDigit">accountDigit*</label>
</div>


<div class="form-floating mb-3">
    <input type="text" name="branchNumber" id="branchNumber" class="form-control" placeholder="branchNumber" value="<?=$d->branchNumber?>">
    <label for="branchNumber">branchNumber*</label>
</div>


            </div>
        </div>

        <div class="row">
            <div class="col">
                <div style="display:flex; justify-content:end">
                    <button type="submit" class="btn btn-success btn-ms">Salvar</button>
                    <input type="hidden" id="codigo" value="<?=$_POST['cod']?>" />
                </div>
            </div>
        </div>
    </form>

    <script>
        $(function(){
            Carregando('none');

            $("#cpf").mask("999.999.999-99");
            $("#telefone").mask("(99) 99999-9999");

            $('#form-<?=$md5?>').submit(function (e) {

                e.preventDefault();

                var codigo = $('#codigo').val();
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
                        // if(dados.status){
                            $.ajax({
                                url:"financeira/clientes/index.php",
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