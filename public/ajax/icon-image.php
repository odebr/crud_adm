<?php 
 if (isset($_REQUEST['ajaxcallid'])) {
    if ((int) $_REQUEST['ajaxcallid'] == 26) {
        $personData = json_decode($_REQUEST['person']);
		
		//print_r($personData);
		
      $imagename57 = $personData[0]->name;
	  $imagename60 = $personData[1]->name;
	  $imagename72 = $personData[2]->name;
      $imagename76 = $personData[3]->name;
      $imagename114 = $personData[4]->name;
      $imagename120 = $personData[5]->name;
      $imagename144 = $personData[6]->name;
      $imagename152 = $personData[7]->name;
      $imagename180 = $personData[8]->name;
      $imagename192 = $personData[9]->name;
      $imagename32 = $personData[10]->name;
      $imagename96 = $personData[11]->name;
      $imagename16 = $personData[12]->name;

	  echo $data = $imagename57.','.$imagename60.','.$imagename72.','.$imagename76.','.$imagename114.','.$imagename120.','.$imagename144.','.$imagename152.','.$imagename180.','.$imagename192.','.$imagename32.','.$imagename96.','.$imagename16;
        $postalCode = $personData->PostalCode;
        $returnData = json_encode($personData);
    }
}
?>