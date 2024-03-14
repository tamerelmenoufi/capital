<?php

$campos = [
    'AC',
    'AL',
    'AP',
    'AM',
    'BA',
    'CE',
    'DF',
    'ES',
    'GO',
    'MA',
    'MT',
    'MG',
    'PA',
    'PB',
    'PR',
    'PE',
    'PI',
    'RJ',
    'RN',
    'RS',
    'RO',
    'RR',
    'SC',
    'SP',
    'SE',
    'TO'
];

foreach($campos as $i => $campo){
?>

<option value="<?=$campo?>" <?='<?=(($d->document_issuingState == \''.$campo.'\')?\'selected\':false)?>'?>><?=$campo?></option>

<?php
}
?>