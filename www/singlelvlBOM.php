<?php
$file_name = 'singlelvlBOM';
$page_title = 'RepRap Engineering Management // Single Level Yoooo!';
$pageFeatures=array("bomTools");
require('./header.php');
include('./incs/table_sortable_head.inc');

/*Get single level BOM*/
$inputPN=$PNset;
$bom = getBOM($inputPN,'singlelvlBOM');

//Throw errors, if any!
if($errorMsg){
  popUp('fatal',$errorMsg,'BOM Error!');
}
?>

<?php

/*Generate full table for all parent child relationships*/
echo '<table id="SingleLevelBOMtable">';
?>
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
    <col id="col1_7"></col>
    <!--col id="col1_8"></col-->
  </colgroup>
  <thead>
    <tr>
      <td>PN</td>
      <td>DESCRIPTION</td>
      <td>ITEM</td>
      <td>QTY</td>
      <td>UOM</td>
      <td>SOURCE</td>
      <td>REV</td>
      <!-- td>CHANGE#</td -->
    </tr>
  </thead>
  <tbody>
  <?php //Populate the table
    if(!$errorMsg){
      foreach ($bom as $childitem) {  
        echo '<tr>
          <td>'.$childitem->pn.'</td>
          <td>'.$childitem->description.'</td>
          <td>'.$childitem->itemnum.'</td>
          <td>'.$childitem->qty.'</td>
          <td>'.$childitem->uom.'</td>
          <td>'.$childitem->source.'</td>
          <td>'.$childitem->rev.'</td>
        </tr>'; //<td>'.$childitem->changeno.'</td>
      }
    }
  ?>
  </tbody>
</table>
<script type="text/javascript">
initSortTable('SingleLevelBOMtable',Array('S','S','N','N','S','S','S'));
</script>
</body>
<?php
include('./footer.inc');
?>
</html>