<?php
require_once('fileUtilities/fileSearchFuncs.inc');

//Find dB credentials & connect to the db
$db_connect_file_dir= $_SERVER['DOCUMENT_ROOT'];
$db_connect_file_name = 'db_connect_info.inc';
$dirCount = 0;
while($dirCount < 10){
  $file = $db_connect_file_dir.'/'.$db_connect_file_name;
  if(file_exists($file)){
    require($file);
    connectToBOMDb();
    break;
  }
  else{
    $db_connect_file_dir = upDir($db_connect_file_dir);
    $dirCount=$dirCount + 1;
  }
}

?>