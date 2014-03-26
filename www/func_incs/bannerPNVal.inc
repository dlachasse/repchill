<?php
////VALIDATE PN & SET BANNER

//check if PN has changed
if (isset($_SESSION['bomitem_array'])) {  //if a BOM already exists in memory, and the part number that you are working on hasn't changed, load it to the page!
  if($_SESSION['lastEditedPN'] != $_SESSION['pn']) {   //you changed PNs, clear that BOM out!
    unset($_SESSION['bomitem_array']);
  }
  else{ //load existing BOM if there's one in memory for this part!
   $bomitem_array = $_SESSION['bomitem_array']; 
  }
}

//setup page name
if(!isset($page_name)) $page_name='This page needs a name defined as $page_name = ... @ the top of the file';

echo '<h1>';
if (validatePNexists($PNset)){ //validates if that the PN exists
  switch ($page_name) {
    case 'editBOM':
      echo 'Editing BOM of: '.$PNset;
      break;
    case 'xplodeBOM':
      echo 'xPloded BOM of: '.$PNset;
      break;
    case 'singlelvlBOM':
      echo 'BOM of: '.$PNset;
      break;
    case 'editpn':
      echo 'Edit part: '.$PNset;
      break;
    default:
      echo $page_name;
      break;
  }
}
else{
  //Handle pages that do not require a PN to be set or validated (i.e., createPN)
  switch ($page_name) {
      case 'createPN':
        echo 'Create a new part number!';
        break;
      default:
        if(!$PNset){
          $errorMsg.='Please enter a real part number<br/>';
            echo 'Please enter a PN';  
          }
        break;
    }
}
echo '</h1>';
?>