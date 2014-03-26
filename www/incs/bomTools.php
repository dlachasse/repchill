<?php

//bom item root class
class bomitem{
}

//bomitem, that when created creates an array of sub-bomitemXploder
class bomitemXploder extends bomitem {
    
    function __construct(){
        $args = func_get_args();
        //populate pn and parent params
        for( $i=0, $n=count($args); $i<$n; $i++ )
            switch ($i) {
                case 0:
                    $this->pn=$args[$i];
                    $this->description=getBOMDetail($this->pn,'description');
                    break;
                case 1:
                    $this->parent=$args[$i];
                    break;
                default:
                    $errorMsg.='Your inputs into creating a BOM exploder are bogus!';
                    break;
            }
        $partDeets = getFullPartDetails($this->pn);
        foreach ($partDeets as $key => $value) {
          $this->$key=$value;
        }
        $this->bom=getBOM($this->pn,'singlelvlBOM','True');
        $this->childNumCounter=0;
        $this->headersWritten=False;
    }
}

//validatePNformat
//Returns nothing if OK, and an error if the wrong format
function validatePNformat($PNset){
  $errorMsgPNformatval= '';
  if  (strlen($PNset)!=12 ||
          !is_numeric(substr($PNset, 0,2)) ||
          !is_numeric(substr($PNset, 3,6)) ||
          !is_numeric(substr($PNset, -2)) ||
          !substr($PNset, 3,1) == "-" ||
          !substr($PNset, -3,1) == "-")
          {
            $errorMsgPNformatval.= "BAD PN // THE PART NUMBER YOU HAVE ENTERED IS NOT IN ##-######-## FORMAT!\n\n<br/>";
          }
  return $errorMsgPNformatval;
}
// Returns an array full of BOM objects (children)
// of a specified part number.
function getBOM($PN,$page,$nonIndexed=False){
  switch ($page) {
      case 'editBOM':
         $queryBOM = "SELECT 
        `parentchild`.`child`,
        `parentchild`.`qty`,
        `parentchild`.`itemnum`,
        `parentchild`.`id`,
        `item`.`description`,
        `item`.`uom`
        FROM parentchild LEFT JOIN `cdarin5_bom`.`item` ON `parentchild`.`child` = `item`.`PN`  WHERE((parentchild.parent ='".$PN."'));";
        break;
      case 'singlelvlBOM':
        $queryBOM = "SELECT  
        `parentchild`.`child`  ,
        `parentchild`.`qty` ,  
        `parentchild`.`itemnum`,
        `item`.`description` ,  
        `item`.`uom` ,  
        `item`.`source` ,  
        `item`.`rev`  
        FROM item LEFT JOIN  `cdarin5_bom`.`parentchild` ON  `item`.`PN` =  `parentchild`.`child`
        WHERE  `parentchild`.`parent` = '".$PN."'";
        break;
     default:
       # code...
       break;
   } 

  $bom_item_query_results = mysql_query($queryBOM) or die(mysql_error());
 
  //Initialize BOM as stored in the system
  $bomitem_array=array();

  while($row = mysql_fetch_array($bom_item_query_results)){ 
    
    $$row['child'] = new bomitem();
    $$row['child']->itemnum = $row['itemnum'];
    $$row['child']->qty = $row['qty'];
    $$row['child']->uom = $row['uom'];
    $$row['child']->pn = $row['child'];
    $$row['child']->description = $row['description'];
    $$row['child']->deleteflag = 0;
    if($page=='singlelvlBOM'){  //add singleLvl unique items
      $$row['child']->source = $row['source'];
      $$row['child']->rev = $row['rev'];
    }
    if($page=='editBOM'){ //add editBOM unique items
      $$row['child']->id = $row['id'];
    }
    if (!$nonIndexed){
      $bomitem_array[$row['child']]=$$row['child']; //append bomitem object to array with key as the item number  
    }
    else{  //index 0,1,2
      $bomitem_array[]=$$row['child'];
    }
    

  } 
  return $bomitem_array;
}

//getParents
//getParents returns a list of part numbers that a inputted PN reports to
function getParents($inputPN){
  $queryBOM = "SELECT 
      `parentchild`.`parent`
      FROM parentchild 
      WHERE((parentchild.child ='".$inputPN."'))";

  $parent_results = mysql_query($queryBOM) or die(mysql_error());
  $parents= array();

  while($row = mysql_fetch_array($parent_results)){ 
    $parents[]=$row['parent'];
  }
  return $parents;
}

//getFullPartDetails returns all values stored in the item table
function getFullPartDetails($part){
  $sql = "SELECT * FROM `item` WHERE PN='".$part."'";
  $results =  mysql_query($sql) or die(mysql_error());
  return mysql_fetch_array($results,MYSQL_ASSOC);
}

/* 
getBOMDetail returns the value from the item table for the field the user specifies
*/
function getBOMDetail($pn,$field){
    $query = "SELECT $field FROM item WHERE(item.pn ='".$pn."')";
    $bom_item_query_results = mysql_query($query) or die(mysql_error());
    $fieldIfFound=False;
    while($row = mysql_fetch_array($bom_item_query_results)){ 
      $fieldIfFound = $row[$field];
    }
    return $fieldIfFound;
}

//recursiveBOMCheck
//recursiveBOMCheck takes a part and a list of parts that should report to said part as inputs, and makes sure that standard business heirarchy logic is applied.  i.e., if part A has a B, you cannot add an A to part B, or an infinite loop of parts would exists!
function recursiveBOMCheck($part,$partBOM){
  
  //initialize
  $recursiveBOMerrors=''; //initiallize as no errors!
  $allCurrLevelGrandParents=array(); //stores a flat list of all parents, grandparents, ggps, etc
  $cummulativeGrandparents = array(0=>$part); //add the parent part for this BOM to cummlative grandparents.  YEA, we know it's not a grandparent, just a parent. get over it.
  //grab first set of parent reports
  $partParents=getParents($part); //partParents will store (now) the parents of  the input part, but echoeventually every part that touches 'part' in the verticle tree  
  
  if($partParents){ //if the starting part is not an orphan part
    $moreParents=True; //setting True will enable the upward scouring loop to begin
    //$partParents = $partParents.$PNset;
    $cummulativeGrandparents=array_merge($cummulativeGrandparents,$partParents);
    while($moreParents){ //check for BOM violations while we parse through full bom reports 
      $moreParents= False; //only toggle if we find parents
      foreach ($partParents as $parent) {
        $grandparents = getParents($parent);
        if($grandparents){
          $moreParents = True;
          $allCurrLevelGrandParents = array_merge($allCurrLevelGrandParents,$grandparents);
          $cummulativeGrandparents=array_merge($cummulativeGrandparents,$grandparents);
        }
      }
      $partParents=$allCurrLevelGrandParents; //the loop only searches $partParents, thus only continue searching upwards on the recent finds (recent finds = $allCurrLevelGrandParents)
      $allCurrLevelGrandParents = array(); //reset the current grandparent finds for next upward search
    }
  }

  foreach ($partBOM as $bomitem) { //see if any of the BOM items you are editing are in the parental heirarchy (BAD!)
    if(in_array($bomitem, $cummulativeGrandparents)){
      $recursiveBOMerrors.="Part $part reports up to part $bomitem.  You cannot add it here.<br />";
    }
  }
  return $recursiveBOMerrors;
}

function partBOMUpdater($bomItem) {
    $query = "UPDATE parentchild
    SET `itemnum`='$bomItem->itemnum', `qty`='$bomItem->qty'
    WHERE `id`='$bomItem->id'";
    $result = mysql_query($query) or die(mysql_error());
}

function partAdder($bomItem, $parent) {
    $query = "INSERT INTO parentchild (parent,child,itemnum,qty) VALUES ('$parent','$bomItem->pn','$bomItem->itemnum','$bomitem->qty')";
    $result = mysql_query($query) or die(mysql_error());
}

function partDeleter($pnDelete, $parent) {
    $query = "DELETE FROM parentchild WHERE `parentchild`.`parent` = '$parent' AND `parentchild`.`child` = '$pnDelete'";
    $result = mysql_query($query);
}
//BuildBOM takes the _POST bom submitted by the form and builds a bunch of bom item objects
function BuildBOM($arrayWithBOMItems){
  $bom = array();
  $bomDeletes = array();
  $buildErrs='';
  foreach($arrayWithBOMItems as $k => $nbic){ //nbc = new bom item component
    $nbic_type = substr($k,6,2); //attempts to extract the title from the control.  The controls should be named in txtbx_XZY format, such that the type can be figured out via string metehod once posted into the $_POST var
    //echo $k.", is a: ".$nbic_type." with value: ".$nbic."<br />";
    switch ($nbic_type) {
      case 'pn':
        $validPN = validatePNexists($nbic);
        if(strlen($nbic)){
          $$nbic = new bomitem();
          $currBOMitem = $nbic;
          $bom[$nbic]=$$nbic;
        }
        if ($validPN){ //add values that wouldn't have been carried over from first submit
          $$currBOMitem->pn = $nbic;
          $$currBOMitem->description = $validPN; //valid PN carries the description of the PN if the PN exists
          $$currBOMitem->uom=getBOMDetail($currBOMitem,'uom');
          $$currBOMitem->deleteflag = 0;
        }
          else{
            if (empty($errorMsg)) {
              $errorMsg = "PN ".$nbic." does not exist! It will be auto-removed if not selected for deletion.<br />";
            }
            else {
              $errorMsg .= "PN ".$nbic." does not exist! It will be auto-removed if not selected for deletion.<br />";
            }
            $$currBOMitem->description='(invalid PN)';
          }
        break;
        
      case 'dl':
        $bomDeletes[]=substr(strstr($k, 'dl'), 2); //add the part number that we need to delete out of the BOM
        break;

      case 'it':
          if(isset($$currBOMitem)){
            $$currBOMitem->itemnum = $nbic;  
          }
        break;

      case 'qt':
        if(isset($$currBOMitem)){
          $$currBOMitem->qty = $nbic;
        }
        break;

      case 'id':
        if(isset($$currBOMitem)){
          $$currBOMitem->id = $nbic;
        }
        break;
      case 'uo':
       if(isset($$currBOMitem)){
          $$currBOMitem->uom = $nbic;
        }
        break;
      default:
        # code...
        break;
    }
  }
  foreach ($bomDeletes as $key => $value) { //delete all parts that were marked for deletion!
    unset($bom[$value]);
  }
  return array('bom' => $bom,'error' => $buildErrs);
}

?>