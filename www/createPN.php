<?php
$page_title = 'RepRap Engineering Management // Create a part number!';
$pageFeatures=array("debug","upload","profanityFilter","bomTools","fileOps");
$successNotes ='';
$pn_max_length = 12;
$description_max_length = 40;

require('./header.php');
//$errorMsg = ""; //reinit errorMsg after all dependencies load

//Process submitted new PN
if (isset($_POST['submitted'])){
    unset($_POST['submitted']);

  //Submit new PN to database!
  if (NoDuplicatesTest()){
    $errorMsg .="PN ".$_POST['pn']." already exists in the database!<br />";
  }
  //Validate the input!-check that all fields have values
  if (!($_POST['pn'] && 
        $_POST['description'] && 
        $_POST['source'] && 
        $_POST['uom'] && 
        $_POST['lifecycle'])){
      $errorMsg .=  'You have not filled out all of the required fields!</br>';
  }
  
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
    
    //Delete any files older than 3 minutes old
    deleteOldFiles("",3,$defaultUploadedFileDir);

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
    else{

      //UPDATE THIS TO INCLUDE FILE UPLOADS!!!

      //build the insert new string
      $insertNewQuery = "INSERT INTO ".DB_NAME.".`item` (`PN`, `description`, `source`, `uom`, `rev`, `lifecycle`) VALUES(
          '".$_POST['pn']."',
          upper('".($_POST['description'])."'), 
          '".$_POST['source']."', 
          '".strtoupper($_POST['uom'])."', 
          '".$rev."', 
          '".strtoupper($_POST['lifecycle'])."'); "; 
      
      //update the DB
      mysql_query($insertNewQuery) or die(mysql_error());

      $successNotes="<b>".$_POST['pn']." // ".$_POST['description']."</b> created successfully!</br></br>\n".$successNotes;
      popUp('big-greeny',$successNotes,'Create PN!');
    }

    deleteOldFiles($_POST['pn'],5,$defaultUploadedFileDir); //delete all temp files for this PN that have either errored out or uploaded
}

?>

<div id="formWrapper">
  <div id="formWrapper2">
    <form id="newPN" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <span class="attrDesc">PN:</span><span class="attribute"><input type="text" name="pn" value="<?php if (isset($_POST['pn'])) echo $_POST['pn']; ?>" maxlength="<?php echo $pn_max_length; ?>" /></span></br>
      <p>Description:</p><div class="attribute"><input type="text" name="description" value="<?php if (isset($_POST['description'])) echo strtoupper($_POST['description']); ?>" maxlength="<?php echo $description_max_length; ?>" /></div>
      <p>Procurement:</p><div class="attribute">
        <?php
          $source= array(
            '' => '',
            'buy'=> 'buy',
            'routable'=> 'routable',
            'phantom'=> 'phantom'
            );

          if (isset($_POST['source'])){
            setupDropdowns('source',$source,$_POST['source']);
          }
          else{
            setupDropdowns('source',$source);
          }
       
      ?>
       </select></div>
      
      <p></p><div class="attribute">
        <ul>
          <li>Buy: This item is directly procurable</li>
          <li>Routable: A consumable assembly or kit whose children parts must be procured independently</li>
          <li>Phantom: A BOM placeholder or non-consumable</li>
        </ul></div>

      <p>UoM:</p><div class="attribute">
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
      if (isset($_POST['uom'])){
        setupDropdowns('uom',$uom,$_POST['uom']);
      }
      else{
        setupDropdowns('uom',$uom);
      }
      ?>
         </select></div>

      <p>Lifecycle:</p><div class="attribute">
          <?php 
          $lifecycle = array('' => '',
            'production' => 'production',
            'rd' => 'rd');

          if (isset($_POST['lifecycle'])){
            setupDropdowns('lifecycle',$lifecycle,$_POST['lifecycle']);
          }
          else{
            setupDropdowns('lifecycle',$lifecycle);
          }
          ?>
        </div>

      <p></p><div class="attribute"><ul> 
        <li>Production: This item is 'official' &amp; accepted by the RepRap development community</li>
        <li>R&amp;D: This item is still in the development or testing phase</li>
      </ul></div>

      <!--uploader-->
      <p>Existing files:</p>
        <div class="fileUploaderZone">
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
      </div>
      <div style="width:350px;text-align:justify;">
      File Rules: </br>
        <ul>
          <li>Files must be named in XX-XXXXXX-XX_REV.ext format</li>
          <li>Your files may be auto-deleted 5 minutes after loading into this page if not submitted.  Confirm all your files are listed in the 'success' window once submitted</li>
          <li>
            <p><a id="fileTypeTip" href="#">accepted file types?</a></p>
        </ul>
      </div>

      <input type="submit" name="Submit PN" value="Create PN!" /></td></tr>
      <input type="hidden" name="submitted" value="TRUE" />
    </form>
  </div>
</div>

<?php include('./footer.inc'); ?>