<?php
$file_name = 'editPN';
$page_title = 'RepRap Engineering Management // Edit a part number!';
//parameters!
$successNotes ='';
$pn_max_length = 12;
$description_max_length = 40;

require('./header_script_p1.inc');
?>
<link href="incs/uploader/client/fileuploader.css" rel="stylesheet" type="text/css"> 
<?php
require('./header_script_p2.inc');
include('./profanity_filter.inc');
require('./incs/bomTools.php');
require('./incs/editPNfuncs.php.inc');
require('./incs/uploader/allowedFileTypes.php.inc');
require('./incs/fileUtilities/fileOps.inc');
require('./incs/bannerPNVal.inc');
include('./incs/drawingLinks.php');
include('./incs/kint/kint.class.php');

//init vars
$errorMsg = "";
if (!isset($_POST)) $_POST=''; //set $_POST to empty s.t. sticky form control functions recieve at minimum an empty string

//debug
/*d($_SERVER);
d($_GET);
*/
d($_POST);


//Handle form if it has been submitted to itself
if (isset($_POST['submitted'])){
  unset($_POST['submitted']);

  //validate the input!-check that all fields have values
  if (!($_POST['pn'] && $_POST['description'] && $_POST['source'] && $_POST['uom'] && $_POST['lifecycle'])){
      $errorMsg .=  'You have not filled out all of the required fields!</br>';
  }

  //validate the PN
  $errorMsg.= validatePNformat($PNset);

    $profane_check = new profanityFilter();
    if ($profane_check->scanText($_POST['description'])>0){
            $errorMsg.= "PROFANE // PLEASE SELECT LESS PROFANE TEXT FOR PART DESCRIPTION! <br/>";
    }
    
    //set the revision
    if ($_POST['lifecycle']=='production'){
      $rev='A';
    }
    else{
      $rev=1;
    }

    //make sure that the uploaded files, if any, are valid (NOTE: existing file validation is built into the uploader.  See below where we instatntiate the uploader itslef)
    
    //Delete any files older than 5 minutes old
    deleteOldFiles("",5,$defaultUploadedFileDir);

    //Validate file naming format
    $fileUploads=showFilesToBeUploaded($_POST['pn']); //(in fileOPs.inc)
    $filesToUpload = $fileUploads[0];
    $filesFailing = $fileUploads[1];

      //Alert if we haven't uploaded anything
      if(count($filesToUpload)<1){
        $successNotes.="No files have been uploaded.  Consider adding drawings & spec sheets.</br></br>\n";
      }

      //Alert user about the good files we're adding
      if (count($filesToUpload)>0) {
        $successNotes.="The following files shall be uploaded:\n<ul>";
        foreach ($filesToUpload as $filedetails) {
            foreach ($filedetails as $key => $value) {
              switch ($key) {
                case'rev':
                  $rev=$value;
                  break;
                case 'filename':
                  $filename = $value;
                  $successNotes.="<li>$filename</li>\n";
                  break;
            }
          }
          $errorMsg.= StoreFile($filedetails,$_POST['pn']);
        }
        $successNotes.="</ul>";
      }
      //Alert user about the bad files, and why we're not uploading them
      if (count($filesFailing)>0) {
        $successNotes.="The following files shall NOT be uploaded:\n<ul>";
        foreach ($filesFailing as $filearray) {
          foreach($filearray as $filename => $error){
            $successNotes.="<li>$filename: $error</li>\n";
          }  
        }
        $successNotes.="</ul></br><p class=\"smallText\">Note: Some files above may be from other users in session.  They will be handled independently from your uploads.</p>";
      }
    if ($errorMsg) {
        popUp('fatal',$errorMsg,'Error creating PN!');
    }
    else {
      //QUERY TIME!!!!!!!!!!!!!!!!! EGGS ALL OVER EVERYONE'S FACES!
      
        $updatePartQuery = "UPDATE `cdarin5_bom`.`item` SET 
        `description` = upper('".($_POST['description'])."'),
        `source` = '".$_POST['source']."',
        `uom` = '".strtoupper($_POST['uom'])."',
        `rev` = '".$rev."',
        `lifecycle` = '".strtoupper($_POST['lifecycle'])."'
        WHERE `item`.`PN` = '".$_POST['pn']."'";
      
      //update the DB
      mysql_query($updatePartQuery) or die(mysql_error());

      $successNotes="<b>".$_POST['pn']." // ".$_POST['description']."</b> created successfully!</br></br>\n".$successNotes;
      popUp('big-greeny',$successNotes,'Create PN!');
    }
    deleteOldFiles($_POST['pn'],5,$defaultUploadedFileDir); //delete all temp files for this PN that have either errored out or uploaded
  
}
?>

<form name="editpn" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
 <table border="0">
    <col width="300" />
    <col width="500" />
  <tr class="input"><td><p class="thick">PN:</p></td><td align="left">
   <input type="text" name="pn" value="<?php echo stickyFieldEditPN($PNset,'pn',$_POST); ?>" maxlength="<?php echo $pn_max_length; ?>" /></td></tr>
  
  <tr class="input"><td><p p class="thick">Description:</p></td><td align="left">
   <input type="text" name="description" value="<?php echo stickyFieldEditPN($PNset,'description',$_POST); ?>" maxlength="<?php echo $description_max_length; ?>" /></td></tr>
  
  <tr class="input"><td><p p class="thick">Procurement:</p></td><td align="left">
    <?php
      $source= array(
        '' => '',
        'BUY'=> 'BUY',
        'ROUTABLE'=> 'ROUTABLE',
        'PRODUCTION'=> 'PRODUCTION'
        );
      if (isset($_POST['source'])){
        setupDropdowns('source',$source,$_POST['source']);
      }
      else{
        setupDropdowns('source',$source,getBOMDetail($PNset,'source'));
      }
  ?>

   </select></td></tr>
  
  <tr><td></td><td><li>Buy: This item is directly procurable</li></td></tr>
  <tr><td></td><td><li>Routable: A consumable assembly or kit whose children parts must be procured independently</li></td></tr>
  <tr><td></td><td><li>Phantom: A BOM placeholder or non-consumable</li></td></tr>
  
  <?php

  $uom= array('' => ''
    ,'ea' =>  'each'
    ,'in' =>'inches'
    ,'ft' =>'feet'
    ,'cm' => 'centimeters'
    ,'m' => 'meters'
    ,'cu ft' => 'cubic feet'
    ,'cu m' => 'cubic meters'
    ,'qt' => 'quarts'
    ,'gl' => 'gallons'
    ,'lb' => 'pounds'
    ,'oz' => 'ounces'
    ,'g' => 'grams'
    ,'kg' => 'kilograms');
  
  echo '<tr class="input"><td><p p class="thick">UoM:</p></td><td align="left">';
 
  if (isset($_POST['uom'])){
    setupDropdowns('uom',$uom,$_POST['uom']);
  }
  else{
    setupDropdowns('uom',$uom,getBOMDetail($PNset,'uom'));
  }

  ?>
     </select></td></tr>
  <tr class="input"><td><p p class="thick">Lifecycle:</p></td><td align="left">
      <?php 
      $lifecycle = array('' => '',
        'production' => 'production',
        'rd' => 'rd');

      if (isset($_POST['lifecycle'])){
        setupDropdowns('lifecycle',$lifecycle,$_POST['lifecycle']);
      }
      else{
        setupDropdowns('lifecycle',$lifecycle,getBOMDetail($PNset,'lifecycle'));
      }
      ?>
    </td></tr>
  <tr><td></td><td><li>Production: This item is 'official' &amp; accepted by the RepRap development community</li></td></tr>
  <tr><td></td><td><li>R&amp;D: This item is still in the development or testing phase</li></td></tr>

  <!--uploader-->
  <tr class="input">
    <td style="vertical-align:top">
    Existing files:<br/>
      <?php GenerateFileURLs($PNset,$fileStoreDir,$allFiles=True); ?>
    </td>
    <td colspan=1 align="right">
    <script src="incs/uploader/client/fileuploader.js" type="text/javascript"></script>
    <script>        
        function createUploader(){            
            var uploader = new qq.FileUploader({
                allowedExtensions: <?php echo $allowedFileTypes; ?>,
                sizeLimit: 300000,
                element: document.getElementById('file-uploader'),
                action: 'incs/uploader/server/php.php',
                debug: false
            });           
        }
        
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader;     
    </script>
    <div id="file-uploader">
    <noscript>
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>
    </div>
      <div style="width:350px;text-align:justify;">
      File Rules: </br>
        <ul>
          <li>Files must be named in XX-XXXXXX-XX_REV.ext format</li>
          <li>Your files may be auto-deleted 5 minutes after loading into this page if not submitted.  Confirm all your files are listed in the 'success' window once submitted</li>
          <li>
            <p><a id="fileTypeTip" href="#">accepted file types?</a></p>



            <?php //echo $allowedFileTypes ?></li>
        </ul>
      </div>
    </td>
  </tr>

  
  <tr><td></td><td align="right"><input type="submit" name="Submit PN" value="Create PN!" /></td></tr>
  </table>

      <input type="hidden" name="submitted" value="TRUE" />
    </form>

</div>
<?php include('./footer.inc'); ?>