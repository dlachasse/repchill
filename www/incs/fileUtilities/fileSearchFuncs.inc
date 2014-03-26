<?php
//function moves up a directory
function upDir($startDir){
  return dirname($startDir);
}

//find file or folder in parent dirs
//returns path string of file or folder (doenst work for folders yet)
//used in: FileLinksQTip.php
function FindInParentDir($startDir, $fileOrfolder, $numDirsUpToScan,$pathType='server',$folder=False){
  $dirCount = 0;
  while($dirCount < $numDirsUpToScan){
    if(!$folder){
      $path = $startDir.'/'.$fileOrfolder;
      if(file_exists($path)){
        break;
      }
      else{
        $startDir = upDir($startDir);
        ++$dirCount;
      }
    }
    if($folder){
      $path = $startDir."/$fileOrfolder";
      if(is_dir($path)){
        break;
      }
      else{
        $startDir = upDir($startDir);
        ++$dirCount;
      }
    }
  }
  if($pathType=='url'){
    //$path = substr($path,1+strripos($path,'/')+  strlen($fileOrfolder),1000); //returns just the file name from the originating page
    //echo 'path: '.$path.'<br/>';
                $path = $fileOrfolder;
    for ($i = $dirCount; $i >0; $i--) {
      $path="../$path";
    }
    $path='./'.$path;
  }
  return $path;
}
?>