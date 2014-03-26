<?php
/////////
// stdlib - includes diverse php BE functions specific for repchill.

//Checks if input value is an integer, even if the int is captured in a string!
function is_integer2($v) {
  $i = intval($v);
  if ("$i" == "$v") {
    return TRUE;
  } else {
    return FALSE;
  }
}

//echoMultiple outputs an inputted # of inputted string
function echoMultiple($str,$numEchos,$offsets=0,$indentHeirarchyMode=False,$numExpectedOffests=2){
  $result='';
  if ($indentHeirarchyMode){
    //numEchos is now logically translated into #indents
    $numEchos=$numEchos*$numExpectedOffests + $offsets;
  } 
  for($i=0;$i<$numEchos;$i++){
    $result.=$str;
  }
  return $result;
}

//takes a string, and removes ALL newlines!
function replace_newline($string) {
  return (string)str_replace(array("\r", "\r\n", "\n"), '', $string);
}

function setupDropdowns($control_title,$input_array,$_POSTval=False){

  echo "<select name=\"$control_title\"><br />";
  
  foreach ($input_array as $k => $v){
          
          echo "<option value=\"$k\"";

          if ($_POSTval==False && $k==''){
            echo 'selected="selected"';
          }
          else {
            if ($_POSTval!=False){
              if (pow(strcasecmp($_POSTval,$k),2)){  //only if the strings are equal with the output be 0. otherwise output will be positive!
                echo 'selected="selected"';
              }
            }
          }
         echo ">\n\t$v</option><br />";
  }

}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function NoDuplicatesTest(){
  $duplicatePass= False;
  $countPNsQuery = 'SELECT COUNT(*) FROM item WHERE item.PN="'.$_POST['pn'].'";';
  //print($countPNsQuery);
  $numberPNsResult= mysql_query($countPNsQuery) or die(mysql_error());      //query should return a number value of how many PNs are already present (hopefully 0, or else if 1+ it will post the error message following)

  while($row = mysql_fetch_array($numberPNsResult)){                          
      $duplicateFound = $row['COUNT(*)'];
      //echo $duplicatePass."<br />";
    }
  return $duplicateFound;
}

//Include PN validator
require('./incs/gui/pnValidator.php');

function popUp($type,$content,$title){    
    echo "<div id=\"output\"></div>
          <div id=\"overlay\" class=\"web_dialog_overlay\"></div>";

    if($type=='fatal'){
      echo "<div id=\"dialog\" class=\"web_dialog_fatal\">";}
    else{
      echo "<div id=\"dialog\" class=\"web_dialog\">";}
    
    echo "<table style=\"width: 100%; border: 0px;\" cellpadding=\"3\" cellspacing=\"0\">
                <tr>";
    
    if($type=='fatal'){
      echo "<td class=\"web_dialog_title_fatal\">$title</td>
            <td class=\"web_dialog_title_fatal align_right\">";}
    else{
      echo "<td class=\"web_dialog_title\">$title</td>
            <td class=\"web_dialog_title align_right\">";}
                    
    echo "                 <a href=\"#\" id=\"btnClose\">Close</a></td>
                </tr>
                <tr>
                    <td colspan=\"2\" style=\"padding-left: 15px; vertical-align:top;\">
                        <div style=\"height: 300px; overflow: auto;\">";
                          echo $content;
                          echo "</div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
        ";
}
function escapeData($data){
  global $dbc;
  if (ini_get('get_magic_quotes_gpc')) {
    $data = stripslashes($data);
  }
  return mysql_real_escape_string(trim($data), $dbc);
}


?>