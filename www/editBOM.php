<?php
$file_name = 'editBOM';
$page_title = 'RepRap Engineering Management // Create a part number!';
require('./header_script_p1.inc');
require('./incs/table_sortable_head.inc');
include('./header_script_p2.inc');
require('./incs/bomTools.php');
//require('./incs/kint/Kint.class.php');
require('./incs/bannerPNVal.inc'); //setup banner and validate PN!

if (!$PNset){  //PNset is a var that indicates whether the user has entered a PN in the text box in the header
  //echo $errorMsg;
}

//make sure the part is routable and allowed to have a BOM
if(strstr(!strtoupper(getBOMDetail($PNset,'source')),'ROUTABLE') && !strstr(strtoupper(getBOMDetail($PNset,'source')),'BUY')) {
  $errorMsg.='This part is not a buy or a routable!  It cannot have a BOM!<br />';}


/////HANDLE THE FORM!

//Setup the current PN's BOM
if (isset($_POST['submitted']) && ($PNset)){ //ONLY IF WE'VE SUBMITED AND ARE WORKING ON A PN
  $b_return =  BuildBOM($_POST); //bom will hold the entire modified BOM
    $bom = $b_return['bom']; //grab the BOM
    if ($b_return['error']) $errorMsg.=$b_return['error'];//grab any errors found while building bom
  /* The below code cycles through the submited BOM changes and creates a new array of BOM parts that must be added and contrasted with the existing BOM */
}
if ($PNset && !isset($bom)){ //populate bom fresh from the database on first visit ONLY
  $bom = getBOM($PNset,'editBOM');
}



//Continue handling form now that the existing BOM ($bomitem_array) & modified BOM items ($bom) are populated in memory
if (isset($_POST['submitted'])){
//var_dump($_POST);
  //build new bom
  $bomitem_array = array();
  foreach ($bom as $nbi){
    //because DESCRIPTION is from a different table, but part of a bomitem object, query it, and add it to the mod'd BOM parts
    if ($nbi->deleteflag){
      unset($bom[$nbi->pn]);
    }
  }

  $oldPNs=array(); //init empty array (it MUST be defined as such!)
  $oldBOM = getBOM($PNset,'editBOM');
  foreach ($oldBOM as $bomitem) { $oldPNs[]=$bomitem->pn;} //get list of old pns
  foreach ($bom as $bomitem) { //get list of new pns
  	$newPNs[]=$bomitem->pn;
  	$newItemNums[]=$bomitem->itemnum;
  	$newQtys[]=$bomitem->qty;
  }  
  $errorMsg.=recursiveBOMCheck($PNset,$newPNs);

  
   //validate itemnum fields content
   foreach ($newItemNums as $itnum){
   	if (!(is_integer2($itnum) && $itnum>=0)){
   	 $errorMsg.="You have a non 0 or positive item number.  Please fix item number $itnum <br/>";
   	}
   }
   
   //validate that item numbers are unique.
   if (!(count($newItemNums)==count(array_unique($newItemNums)))){
   	$errorMsg.="Please choose unique postive numbers.  You cannot have two of the same item number <br/>";
   } 
   //make sure qty is numeric
   foreach ($newQtys as $qty){
   	if (!(is_numeric($qty))){
   	 $errorMsg.="Quantities must be number.  Please fix qty $qty <br/>";
   	}
   }
   
   //make sure each PN is valid
  
  //UPDATE THE BOM IF NO ERRRORS
  if ($errorMsg){
    popUp('fatal',$errorMsg,'BOM Edit Error!');
    unset($errorMsg);
  }
    else{
      //DB UPDATE
      //determine what parts are new
      foreach ($newPNs as $newPN) { //check if NEW pns exist in the OLD PN BOM
        $partFound = in_array($newPN, $oldPNs); //return the index where this part belongs if it was found at all
        if($partFound){//if this part exists in the old BOM...
          if($bom[$newPN]->itemnum!=$oldBOM[$newPN]->itemnum || 
             $bom[$newPN]->qty!=$oldBOM[$newPN]->qty) { //have the item # or qty changed at all?
              partBOMUpdater($bom[$newPN]); //UPDATE THIS PART
            }
        }
        if(!$partFound){ //Newly added parts!
          if(!$bom[$newPN]->deleteflag == "on") { // add part if not flagged for deletetion
            partAdder($bom[$newPN],$PNset); // part added to BOM
          }
        }
      }
      foreach ($oldPNs as $oldPN) { //Removed PNs. let's find those that are no longer present
        $partFound = in_array($oldPN, $newPNs);
        if(!$partFound) {
          partDeleter($oldPN,$PNset);
        }
      }
    }
}
?>

<?php //Populate the table
if($errorMsg){
  popUp('fatal',$errorMsg,'BOM Edit Error!');
}
?>

<form name="editForm" id="editForm"
  <?php if($PNset !== 0){} else{echo 'class="hidden"';}?>
  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

<?php
if(!$errorMsg){
echo '<input type="button" value="Add Item" onclick="addRow(\'BOMtable\',\'editForm\')" />
<input type="submit" name="update" value="Update BOM" />'; }?>
<input type="hidden" name="submitted" value="TRUE" />
<div class="center">
<table id="BOMtable" style="width:800px" >
  <!--
  id of <col> tags should be "col" + index of table(1 = first table, 2 = second table) + _ (underscore) + column index(1.2.3.4...)
  -->
  <colgroup>
    <col id="col1_1"></col>
    <col id="col1_2"></col>
    <col id="col1_3"></col>
    <col id="col1_4"></col>
    <col id="col1_5"></col>
    <col id="col1_6"></col>


  </colgroup>
  <thead>
    <tr>
      <td class="super_nar">DELETE</td>
      <td>PN</td>
      <td>DESCRIPTION</td>
      <td>ITEM #</td>
      <td>QTY</td>
      <td>UoM</td>
    </tr>
  </thead>
  <tbody>

  <?php //Populate the table
    if(!$errorMsg){
      foreach ($bom as $childitem) {  
        echo '<tr>
          <td><input type="checkbox" class="super_nar" name="chkbx_dl'.$childitem->pn.'" /></td>
          <td><input type="text" name="txtbx_pn_'.$childitem->pn.'" value="'.$childitem->pn.'" /></td>
          <td><input type="text" readonly="readonly" name="desc'.$childitem->pn.'" value="'.$childitem->description.'" /></td>
          <td><input type="text" name="txtbx_itenum'.$childitem->pn.'" value="'.$childitem->itemnum.'" /></td>
          <td><input type="text" name="txtbx_qty'.$childitem->pn.'" value="'.$childitem->qty.'" /></td>
          <td><input type="text" readonly="readonly" name="txtbx_uom'.$childitem->pn.'" value="'.$childitem->uom.'" />
          <input type="hidden" name="txtbx_id'.$childitem->pn.'" value="'.$childitem->id.'" /></td>
        </tr>';
      }
    }
  ?>
    
  </tbody>
</table>
</div>
<script type="text/javascript">
initSortTable('BOMtable',Array('S','S','S','S','N','N'));
</script>

</form>

<?php

if(isset($_POST['submitted'])) $_SESSION['bomitem_array'] = $bomitem_array;
$_SESSION['lastEditedPN'] = $PNset;
include('./footer.inc');
?>