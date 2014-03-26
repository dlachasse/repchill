  </head>

<body bgcolor="#E8FFD1">
<div class="center">
<form class="center" name="PDM" action="" method="GET">
<table class="headerBlock">
 <tr>
  <td><a href="./index.php" tabindex="-1"><img src="http://reprap.org/mediawiki/reprap_logo.png" alt="RepRap Logo"></img></a></td>
  <td>
   <table class="leftUp" BORDER="0">
    <tr>
     <td>
      <table class="leftUp" BORDER="0">
       <tr>
        <td>
         <table BORDER="0">
           <tr>
            <td><font size="5" face="Arial Black, Arial" color="#004D28">REP</font><font size="1" face="Helvetica" color="#004D28">CHILL</font></td></tr>
           
           <tr>
            <td><p class="leftDown"><font size="0">Part Number:</font></p></td></tr>
            <tr>
           <div class="ui-widget">            
              <td><!--<form action="">-->
                <input placeholder="Enter part number..." type="text" id="pn" name="pn" tabindex=1 
                  <?php
                    if (isset($_GET['pn'])) {
                      $_SESSION['pn'] = trim(strtoupper($_GET['pn']));
                    }
                    if (isset($_SESSION['pn'])){
                      echo "value=\"".trim(strtoupper($_SESSION['pn']))."\"/>";
                      $PNset=$_SESSION['pn'];//init active PN 
                    }
                    else{
                      echo "/>";
                      $PNset=False;
                    }
                  ?>
                </td></tr>
            </div>
         </table>
        </td>
        <td>
         <table border="0">
          <tr>
            <td>
                <div class="attention">
                  <div id="createNeditSpace">
                    <div class="editPartButton">
                      <INPUT TYPE="image" src="img/editpart.png" alt="Edit Part" name="editpn" onclick="this.form.action='editpn.php'" />
                    </div>
                  </div>
                </div>   
                <div id="createPNDiv">
                  <div class="attention">
                    <a href="createPN.php"><img src="img/createpn.png" alt="Create New Part Number" /></a>
                  </div>
                </div>              
          </tr>

          <tr>
          
           <td>
            <div class="header_image_link">
              <div class="attention">
                <INPUT TYPE="image" src="img/editBOM.png" alt="Edit a Bill Of Materials" name="editBOM" onclick="this.form.action='editBOM.php'" />
              </div>
            </div>
            </td>
          <td>
            <!-- button below edit part -->
          </td>
          </tr>
         
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td>
      <table class="left" BORDER="0">
       <tr>
        
        <td>
          <div class="drawings" name="drawings" id="header_drawings">
            <div class="attention">
              <img src="img/drwsfiles.png" alt="Drawings/Files" ></img>
            </div>
          </div>
          <div name="drawingData" id="drawingData"></div>
        </td>
        
        <td>
          <div class="attention">
            <input TYPE="image" src="img/xplodBOM.png"  alt="Exploded Bill Of Materials" name="xplodBOM" onclick="this.form.action='xplodBOM.php'" />
          </div>
        </td>   
        <td>
          <div class="attention">
            <INPUT TYPE="image" src="img/singlelvlBOM.png"  alt="Single Level Bill Of Materials" name="singlelvlBOM" onclick="this.form.action='singlelvlBOM.php'" />
          </div>
        </td>   
        
        <td>
          <div class="attention">
            <img src="img/partdetails.png" alt="Part Details"></img></td>    
          </div>
       </tr>
      </table>
     </td>
    </tr>               
   </table>
  </td>
 </tr>
</table>
</form>
</div>