<?php
//deleteOldFiles takes removes all files in a specified directory and removes any file older than a specified age duration
function deleteOldFiles($forceFileDelete='',$timeInMinutes=20,$path = ''){
  global $defaultUploadedFileDir;
  if (strlen($path<2)) $path = $defaultUploadedFileDir;  //set upload dir to std upload dir if not passed by the user
  ini_set('max_execution_time', 300); //allow time to delete big files
  if ($handle = opendir($path)) {
     while (false !== ($file = readdir($handle))) {
        if (strpos($file, '.') != 0){
          if ((time()-filectime($path.$file)) > ($timeInMinutes*60)) {  
            unlink($path.$file);             
          }
          if(strlen($forceFileDelete)>1 && strpos($file, $forceFileDelete)===0){ //delete all files in temp storage that correlate to the PN we are creating/editing--we've alrady uploaded them (or attempted to)  if we are executing this
            unlink($path.$file);             
          }
        }
     }
   }
 }


//show files to be uploaded tells the user which files will be uploaded, and also returns those uploaded files that shall be ignored with error messages attached in array. Also get key file attributes for uploading
function showFilesToBeUploaded($pn){ //pn represents the pn that we are uploading files of
  global $defaultUploadedFileDir;
  $path = $defaultUploadedFileDir;

  if ($handle = opendir($path)) {
      while (false !== ($file = readdir($handle))) {
        //init error codes
        $errorMsg='';

        //ensure PN is at the root of the filename
        if (!strpos($file, $pn)==0 || strpos($file, $pn)===False){
          $errorMsg.="File did not begin with PN.</br>\n";
        }

        //ensure format & rev are OK
        $fileSuffix=substr($file, strlen($pn));
        $revLeader=substr($fileSuffix, 0,1);
        $periodPosition=strpos($fileSuffix, ".");
        $rev=substr($fileSuffix,1,$periodPosition-1);
        $ext = substr($fileSuffix, $periodPosition+1);

          //ensure _ used to divide PN & rev
          if ($revLeader != "_") $errorMsg.="File not formatted correctly.  File will be ignored.</br>\n";

          //ensure rev text matches lifecycle
          $lifecycle = getBOMDetail($pn,'lifecycle'); //only works if part is already in db & you are editing part
          if(is_bool($lifecycle)){ //get lifceycle directly from submitted form
            $lifecycle=$_POST['lifecycle'];
          }

          if (strstr(strtolower($lifecycle),'prod')){
            if (!ctype_alpha($rev)) $errorMsg.="File revision does not match part lifecycle.</br>\n";
          }
          if (strstr(strtolower($lifecycle),'rd')){
            if (!is_numeric($rev)) $errorMsg.="File revision does not match part lifecycle.</br>\n";
          }
        
        //Pass or fail part
        if ($errorMsg){
          if (!strpos($file,'.')==0){  //ignore system files entirely
            $filesNotToUpload[]= array($file => $errorMsg);
          }
        } 
        else{
          $filesToUpload[]= array('fullFilePath' => $path.$file,'filename'=>$file,'rev'=>$rev,'fileext'=>$ext);
        } 
      }
  }
     return  array($filesToUpload,$filesNotToUpload);
}

//BuildFolderStructure -- builds folders one level at a time to dodge permission building errors
function BuildFolderStructure($folderTree)
{
  $targetDir = '';
  $i=0;

  foreach ($folderTree as $subdir) {
    $targetDir.=$folderTree[$i];
    $i+=1;
    //if the target dir doesn't exist, create it
    if (!is_dir($targetDir)){
      mkdir($targetDir, 0777, true);
      //chmod($targetDir, 0777);  // octal; correct value of mode
    }
  }
}

//StoreFile
function StoreFile($filearray){
  $pn = $filearray['filename'];
  $ext = $filearray['fileext'];
  $rev = $filearray['rev'];

  $sourceFile = $filearray['fullFilePath'];
  BuildFolderStructure(array("fileStorage/",substr($pn,0,strlen($pn)-strlen($ext)-strlen((string)$rev)-2)."/",$rev."/"));
  $targetDir ="fileStorage/".substr($pn,0,strlen($pn)-strlen($ext)-strlen((string)$rev)-2)."/$rev/";
  $targetFile = $targetDir."$pn";

  rename($sourceFile,$targetFile);
}

?>