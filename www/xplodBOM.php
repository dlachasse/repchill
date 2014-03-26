<?php
$file_name = 'xplodeBOM';
$page_title = "RepRap Engineering Management // xPloded BOM";
require('./header_script_p1.inc');
require('./incs/table_sortable_head.inc');
echo '<link rel="stylesheet" href="./incs/jqTree/jqtree.css">'."\n";
echo '<link rel="stylesheet" href="./css/jqTreeBOM.css">'."\n";
echo '<script src="./incs/jqTree/tree.jquery.js"></script>'."\n";
include('./header_script_p2.inc');
require('./incs/bomTools.php');
require('./incs/bannerPNVal.inc'); //setup banner and validate PN!
require('./incs/bomXploder.inc'); //import the bomXploder func
require('./incs/kint/Kint.class.php');

//xplode BOM reqs
$inputPN = $PNset;
$$inputPN = new bomitemXploder($inputPN,'TOP_LEVEL_PART');

//error if necessary
if($errorMsg){
  popUp('fatal',$errorMsg,'BOM Edit Error!');
}
else{

//Build form
$staticTitle = 'html';
$dynamicTitle = 'jqTree';
echo '<form name="xplodeForm" ';
    if($PNset !== 0){} else{echo 'class="hidden" ';}
    echo 'action='.$_SERVER['PHP_SELF'].' '.'method="post">';
    echo '
    <input type="submit" name="xplodeType" value='.$staticTitle.' />
    <input type="submit" name="xplodeType" value='.$dynamicTitle.' />
    <input type="hidden" name="submitted" value="TRUE" />
    </form>';


/////HANDLE Form
if (!isset($_POST['submitted'])){
   xPlode($$inputPN); //default explode jqTree (optional vars)
}
else{
    //Get form choice for BOM type
    xPlode($$inputPN,$_POST['xplodeType']);  //can toggle between jqTree or html
    }
}

include('./footer.inc');
?>