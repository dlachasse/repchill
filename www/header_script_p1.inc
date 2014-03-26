<?php 
$file_name =basename($_SERVER['REQUEST_URI'], '.php');
session_start();
global $errorMsg;
$errorMsg=''; //init global error string
$localJQ=False; //use google (non-local js for faster load)
require('./incs/dbEnable.inc'); //connect to db (all pages, as header req's it)

//common gui functions
require('./incs/stdlib.inc');

//init page feature vars
(strpos($file_name,"index") != False) ? require('./incs/bannerPNVal.inc') : "";
in_array("upload", $pageFeatures) ? $defaultUploadedFileDir='./incs/uploader/server/uploads/' : "";
in_array("upload", $pageFeatures) ? require('./incs/uploader/allowedFileTypes.php.inc') : "";
in_array("profanityFilter", $pageFeatures) ? require('./profanity_filter.inc') : "";
in_array("debug", $pageFeatures) ? include('./incs/kint/Kint.class.php') : "";
in_array("bomTools", $pageFeatures) ? require('./incs/bomTools.php') : "";
in_array("fileOps", $pageFeatures) ? require('./incs/fileUtilities/fileOps.inc') : "";

//spec error reporting levels
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>

<!--meta-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
<meta name="keywords" content="Darwin,Mendel,Huxley,Max,Delta,BOM,Bill of Materials,Database,PLC,PDM"></meta>

<!--page title-->
<title><?php echo $page_title ?></title>

<!--remote scripts-->
<?php
if($localJQ=False){
  echo '
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>'."\n".'
    <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>';
  }
else{
  echo '
    <script type="text/javascript" src="./incs/jq.js"></script>'."\n".'
    <script type="text/javascript" src="./incs/jqui.js"></script>';
  }
?>
<script type="text/javascript" src="./incs/jqTip/qtip1.min.js"></script>
<script type="text/javascript" src="./incs/jq_bonus_func.js"></script>

<!--links-->
<link type="text/css" href="./css/index.css" rel="stylesheet" media="screen"></link>
<link type="text/css" rel="stylesheet" href="./css/jquery.qtip.min.css" />
<link rel="shortcut icon" href="http://reprap.org/mediawiki/favicon.ico"></link>

<!--local scripts-->
<script type="text/javascript"> 
  $(window).load(function(){  
  //Check if edit PN needs to be shown.  Must run this onload as PN may be persistent page to page
  ToggleEditPN();
  $("#pn").change(function() {
    ToggleEditPN();
  });

  //prep tool tips
  <?php
    if ($file_name == 'createPN'){
      $allowedFileTypesTips = str_replace(array('[',']',"'",",","  ")," ",$allowedFileTypes);
      echo '
      $("#fileTypeTip").qtip(
        {
          content: '.json_encode($allowedFileTypesTips).'
        });';
      echo $allowedFileTypes;
    }
  ?>

  //setup autocomplete
  $(function() {
    $( "#pn" ).autocomplete({
      source: "./search.php",
      open: function(event, ui){ToggleEditPN();},
      select: function(event, ui){ToggleEditPN();},
      close: function(event, ui){ToggleEditPN();},
      change: function(event, ui){ToggleEditPN();}
    });
  });
  
  //bind drawing elements to qTip file show-er
  $(" .drawings" ).click( function (){
    var pn = $(this).attr('id');
    var elementID = pn;
    ShowDrawingFiles(pn, elementID);
  });

  ShowDialog(true);
  $("#btnClose").click(function (e)
  {
     HideDialog();
     e.preventDefault();
  });

  //Disable enter key from submitting form
  function stopRKey(evt) { 
    var evt = (evt) ? evt : ((event) ? event : null); 
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
    if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
  } 
  document.onkeypress = stopRKey; 

});
</script>

<?php
//Add links post-scripts
echo in_array("upload", $pageFeatures) ? '<link href="incs/uploader/client/fileuploader.css" rel="stylesheet" type="text/css">' : "";
?>