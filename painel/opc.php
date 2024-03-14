<?php

$campo = [
    'nome',
    'data_cadastro',
    'birthdate',
    'gender',
    'phoneNumber',
    'email',
    'maritalStatus',
    'nationality',
    'naturalness',
    'motherName',
    'fatherName',
    'pep',
    'document_type',
    'document_number',
    'document_issuingState',
    'document_issuingAuthority',
    'document_issueDate',
    'address_zipCode',
    'address_street',
    'address_number',
    'address_complement',
    'address_neighborhood',
    'address_city',
    'address_state',
    'bankCode',
    'accountType',
    'accountNumber',
    'accountDigit',
    'branchNumber'
];

foreach($campos as $i => $campo){
?>

<div class="form-floating mb-3">
    <input type="text" name="<?=$campo?>" id="<?=$campo?>" class="form-control" placeholder="<?=$campo?>" value="<?=$d->$campo?>">
    <label for="<?=$campo?>"><?=$campo?>*</label>
</div>

<?php
}
?>