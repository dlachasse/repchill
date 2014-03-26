<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Darwin,Mendel,Huxley,BOM,Bill of Materials,Database,PLC,PDM">
		<link rel="shortcut icon" href="http://reprap.org/mediawiki/favicon.ico">
		<title>RepRap Engineering Management</title>
                
                <style type="text/css">
                    p{font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#004D28;}
                    p.smallitalic {font-size:10px;font-style:italic;}
                    p.bold {font-weight:900;}
                </style>
                
                                <!--- load jQuery (DUH!) --->
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>
                <!--- load dynamicField plugin --->
                <script type="text/javascript" src="/commonassets/scripts/jQuery/forms/jquery.dynamicField-1.0.js"></script>
                <script type="text/javascript">
                 $(document).ready(function() {
                  // pass the dynamic field container to the plugin
                  $("#BOMitems #removable-name-container-1").dynamicField(
                   {
                    maxFields: 8,
                    removeImgSrc: "/demos/assets/images/calendar.gif"
                   }
                  );
                 });
                </script>
                
	</head>

<body BGCOLOR="#E8FFD1">
   
<div id="mainPage.intro"">
    <form name="BOMpn" action="" method="post" target="_blank">
     <table>
         <tr>
             <td><img src="http://reprap.org/mediawiki/reprap_logo.png" alt="RepRap Logo"></img></td>
             <td valign="bottom">
                <table BORDER="0">
                     <tr><td>
                         <table BORDER="0">
                              <tr>
                                 <td><table BORDER="0">
                                 <tr><td><!--<font size="5" face="Arial Black, Arial" color="#004D28">REP</font><font size="1" face="Helvetica" color="#004D28">CHILL</font>--></td></tr>
                                 <tr><td height="10"><p><font size="0"><!--Part Number: --></font></p></td></tr>
                                 <tr><td height="10"><!--<form><input type="text" name="PN"></form>--></td></tr>
                                  </table></td>

                                  <td valign="bottom" align="left">
                                      <table BORDER="0">
                                          <tr><td><!--<img src="img/createpn.png" alt="Create New Part Number">--></img></td></tr>
                                          <tr><td><!--<img src="img/editBOM.png" alt="Edit BOM"></img>--></td></tr>
                                      </table>
                                  </td>
                              
                              </tr>
                         </table>
                          
                         </td></tr>
                         
                    
                    <tr>
                         <td><font size="6" face="Arial Black, Arial" color="#004D28"><i>Edit BOM</i></font></td>
                    </tr>               
                 </table>
             </td>
         </tr>
          

         
    </table>
    </form>
    
</div>

    
<div class="form-container">
 <form action="#" method="post" enctype="application/x-www-form-urlencoded" id="BOMitems" class="uniForm">
  <fieldset class="inlineLabels" id="cfU-204BD901-09C4-BEF8-6008F40594EA946F">
   <div class="ctrlHolder">
    <!--- 
     The dynamicField plugin works upon the convention of using an ID with a "-N" appended to
     it, where "N" is a digit.  So, as you can see below, we are assigning a "-1" to the first
     container.
     
     The default class for the dynamic field "row" used by the plugin is "removable-field-row".
     --->
    <div id="removable-name-container-1" class="removable-field-row">
     <label for="name_1">Name</label>
     <input type="text" name="name_1" id="name_1" value="" class="textInput removable" />
     <img src="/img/spacer.gif" width="16" height="16" alt="" title="Remove This Item" class="" />
    </div>
    <!--- 
     The default class for the add field "trigger" used by the plugin is "add-field-trigger".
     --->
    <div id="add-name-container" class="add-field-container">
     <span class="add-field-trigger">
      <img src="/img/add.gif" alt="" title="Add New Item" />
      Add Row
     </span>
    </div>
   </div>
  </fieldset>
 </form>
</div>    
    
<?php
    /*Form variables retrieve*/
    $inputPN = $_POST['PN'];

        
?>
        
</body></html>

</html>
