<?php
$file_name = 'singlelvlBOM';
$page_title = 'RepRap Engineering Management // Single Level Yoooo!';
include('./header_script_p1.inc');
include('./incs/table_sortable_head.inc');
include('./header_script_p2.inc');
require('./incs/bomTools.php');
require('./incs/fileUtilities/fileOps.inc');
require('./incs/bannerPNVal.inc'); //setup banner and validate PN!
require('./incs/kint/Kint.class.php');

/*Get single level BOM*/
$inputPN=$PNset;
$bom = getBOM($inputPN,'singlelvlBOM');

//Throw errors, if any!
if($errorMsg){
  popUp('fatal',$errorMsg,'BOM Error!');
}
?>

<style type="text/css">

div#divBOMtable {
  margin: auto auto;
  position: relative;
  width: 85%;
  display:block;
}

div.rowBOM{
  width: 100%;
  display:block;
}

div.rowBOM div{
  display:inline-block;
  padding: 2px;
  width:35px;
}
div.rowBOM div.pn{
  width:95px;
}
div.rowBOM div.description{
  width:200px;
}
div.rowBOM div.drws{
  width:40px;
}
div.rowBOM div.singleLvlBOM{
  width:100px;
}

div.rowBOM span{
  display:inline-block;
  text-align: center;
  color: #423;
  font-weight: bold;
}

.icon{
  width: 20px;
  height: 20px;
}

</style>

<div id='divBOMtable'>
<?php

  //setup columns
  $dbCols = array('pn' => 'PN',
    'description' => 'Description',
    'itemnum' =>'Item#',
    'qty' => 'Qty',
    'uom'  => 'UoM',
    'source' => 'SC',
    'rev' =>'Rev');
  $otherCols = array('drws'  => 'Files',
    'whereUsed'  => 'Where Used',
    'singleLvlBOM'  => 'Single Level BOM');
  //setup header row
  echo "<div class=\"rowBOM\">";
  foreach (array_merge($dbCols,$otherCols) as $colCode => $colTitle) {
    echo "<div class=\"$colCode\"><span>$colTitle</span></div>";
  }
  echo "</div>";
  //fill out cell content
  foreach ($bom as $childitem) {  
    echo "<div class=\"rowBOM\" id=\"row_$childitem->pn\"> "; //setup row div
    foreach ($dbCols as $colCode => $colTitle) { //fill out std rows
      switch ($colCode) {
        case 'source':
          echo "<div class=\"$colCode\">".strtoupper(substr($childitem->$colCode, 0,1))."</div>";
          break;
        default:
          echo "<div class=\"$colCode\">".$childitem->$colCode."</div>";
          break;
      }
    }
    foreach ($otherCols as $colCode => $colTitle) { //fill out special feature rows
      switch ($colCode) {
        case 'drws':
          echo "<div class=\"$colCode\"><div id=\"$childitem->pn\" class=\"drawings\">\n
                  \t<img class=\"icon\" src=\"img/fileIcon.png\" alt=\"file download icon\" />
                </div></div>";      
          break;    
        default:
          echo "<div class=\"$colCode\">
            \t<img class=\"icon\" src=\"img/whereUsed.png\" alt=\"where used\" />
          </div>";      
          break;
      }
    }
  echo "</div>"; //close row
  }
?>
</div> <!-- close div table -->

<?php
include('./footer.inc');
?>
</html>