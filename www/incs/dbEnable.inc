<?php

//dbEnable.inc - locates and connects to database

require_once('fileUtilities/fileSearchFuncs.inc');

//Find dB credentials & connect to the db
$db_connect_file_dir= $_SERVER['DOCUMENT_ROOT'];
$db_connect_file_name = 'db_connect_info.inc';
$dirCount = 0;
while($dirCount < 10){ //look for db connection info at least 10 directories up
  $file = $db_connect_file_dir.'/'.$db_connect_file_name;
  if(file_exists($file)){
    require($file);
    connectToBOMDb(); //defined in $db_connect file
    break;
  }
  else{
    $db_connect_file_dir = upDir($db_connect_file_dir);
    $dirCount=$dirCount + 1;
  }
}

?>