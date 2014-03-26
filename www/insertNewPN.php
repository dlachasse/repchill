<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Darwin,Mendel,Huxley,BOM,Bill of Materials,Database,PLC,PDM">
		<link rel="shortcut icon" href="http://reprap.org/mediawiki/favicon.ico">
		<title>RepRap Engineering Management</title>
                
                <style type="text/css">
                    p{font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#004D28;}
                </style>
	</head>

<body
    BGCOLOR="#E8FFD1"
    >

<div id="mainPage.intro"">
    <form name="BOMpn" action="" method="post" target="_blank">
     <table>
         <tr>
             <td><img src="http://reprap.org/mediawiki/reprap_logo.png" alt="RepRap Logo"></img></td>
             <td valign="top">
                <table BORDER="0">
                     <tr><td>
                         <table BORDER="0">
                              <tr>
                                 <td><table BORDER="0">
                                 <tr><td><font size="5" face="Arial Black, Arial" color="#004D28">REP</font><font size="1" face="Helvetica" color="#004D28">CHILL</font></td></tr>
                                 <tr><td height="10"><p><font size="0">Part Number: </font></p></td></tr>
                                 <tr><td height="10"><form><input type="text" name="PN"></form></td></tr>
                                  </table></td>

                                  <td valign="bottom" align="left">
                                      <table BORDER="0">
                                          <tr><td><a href="createPN.php" target="_blank"><img src="img/createpn.png" alt="Create New Part Number" /></a></td></tr>
                                          <tr><td><a href="editBOM.php" target="_blank"><img src="img/editBOM.png" alt="Edit BOM"></a></img></td></tr>
                                      </table>
                                  </td>
                              
                              </tr>
                         </table>
                          
                         </td></tr>
                         
                    
                    <tr>
                         <td><table BORDER="0">
                             <tr>
                                 <td><img src="img/drwsfiles.png" alt="Drawings/Files"></img></td>    
                                 <td><INPUT TYPE="image" src="img/xplodBOM.png"  alt="Exploded Bill Of Materials" name="xplodBOM" onclick="this.form.action='xplodBOM.php'" /></td>   
                                 <td><INPUT TYPE="image" src="img/singlelvlBOM.png"  alt="Single Level Bill Of Materials" name="singlelvlBOM" onclick="this.form.action='singlelvlBOM.php'" /></td>   
                                 <td><img src="img/partdetails.png" alt="Part Details"></img></td>    
                             </tr>
                          </table></td>

                    
                     </tr>               
                 </table>
             </td>
         </tr>
          

         
    </table>
    </form>
    kl;jszlk;fajsfjl;as;falk;falk;sdfjadfl;al;sdjfalk;jsf
</div>
      <?php
      
/*GRAB POSTED VALUES FROM PN FORM SUBMIT, createPN.php*/
      //strtoupper converts all letters to uppercase!
$pn = strtoupper($_POST['pn']);
$description = strtoupper($_POST['description']);
$source = strtoupper($_POST['source']); //i.e. procurement
$uom = strtoupper($_POST['uom']);
$lifecycle = strtoupper($_POST['lifecycle']);

/*DB connect parameter*/
$username = "cdarin5_pubdev";
$password = "pubdev";
$host="localhost";
$database="cdarin5_bom";
$conn = mysql_connect($host,$username,$password);
/*connet to BOM DB*/
mysql_select_db($database, $conn);

      
      
   //Update item's table with new PN
   if (strlen($failureText)>0){
      echo $failureText . "</br>";
      echo "Part creation has failed.  You'll need to figure out why.  Sucks!  :(  Please resolve issues & reattempt.";
   }
   else{
      $insertNewQuery = "INSERT INTO item (PN,description,source,uom,rev,lifecycle) VALUES ('".$pn."','".$description."','".$source."','".$uom."','".$rev."','".$lifecycle."')";
      ECHO "Your new part number has been successfully created.  It was created by means of the following database query: </br></br>";
      echo $insertNewQuery;
      mysql_query($insertNewQuery) or die(mysql_error());

   }
      ?>
   </body>
</html>
