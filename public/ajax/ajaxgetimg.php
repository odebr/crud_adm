<?php 
 if (isset($_REQUEST['ajaxcallid'])) {
    if ((int) $_REQUEST['ajaxcallid'] == 26) {
        $personData = json_decode($_REQUEST['person']);
        echo $imagename = $personData->name;
        $postalCode = $personData->PostalCode;
        $returnData = json_encode($personData);
    }
}
?>