<?php
/* DB CONFIGURATION */
//Use database to store switch values?
	$useDB = true;  //set to true or false
//database connection function file
	$db_connect_file_dir= $_SERVER['DOCUMENT_ROOT']; //in this example, I have my database connection function in the root directory of the server.  if the file isn't present here, the script will keep looking up in parent directories
	$db_connect_file_name = 'db_connect_info.inc';  //name your db connect function 'connectToRotaryDb'.  See below for example db_connect file
/* [END DB CONFIG] */

//EXECUTE
if($useDB){	
	$dirCount = 0;
	while($dirCount < 10){
	  $file = $db_connect_file_dir.'/'.$db_connect_file_name;
	  if(file_exists($file)){
	    require($file);
		connectToFootieDb(); //use your own function's name.
	    break;
	  }
	  else{
	    $db_connect_file_dir = upDir($db_connect_file_dir);
	    $dirCount=$dirCount + 1;
	  }
	}
}
//function moves up a directory
function upDir($startDir){
  return dirname($startDir);
}
?>