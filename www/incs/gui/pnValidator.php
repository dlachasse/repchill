<?php

/* 
validatePN exists makes sure the part exists in the item table.  if it does, it returns the description of the part
*/
function validatePNexists($pn2val,$echo=False){
    $queryMissing = "SELECT description FROM item WHERE(item.pn ='".$pn2val."')";
    $bom_item_query_results = mysql_query($queryMissing) or die(mysql_error());
    $descriptionIfFound=False;
    while($row = mysql_fetch_array($bom_item_query_results)){ 
      $descriptionIfFound = $row['description'];
    }

    if($echo){
    	echo trim($descriptionIfFound);
    }
    else{
    	return $descriptionIfFound;
    }
}

//used exclusively when an AJAX call wishes to validate a PN
if(isset($_GET['valNow'])){
    require('./../dbEnable.inc');
	validatePNexists($_GET['pn'],True);
}


?>