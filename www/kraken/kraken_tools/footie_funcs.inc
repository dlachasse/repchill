<?php
//file funcs
//find file or folder in parent dirs
//returns path string of file or folder (doenst work for folders yet)
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

//function moves up a directory
function upDir($startDir){
  return dirname($startDir);
}

//db connections
/* DB CONFIGURATION */
//Use database to store switch values?
	$useDB = true;  //set to true or false
//database connection function file
	$db_connect_file_dir= $_SERVER['DOCUMENT_ROOT']; //in this example, I have my database connection function in the root directory of the server.  if the file isn't present here, the script will keep looking up in parent directories
	$db_connect_file_name = 'db_connect_info.inc';  //name your db connect function 'connectToRotaryDb'.  See below for example db_connect file

//EXECUTE
if($useDB){
	$db_connect_path = FindInParentDir($db_connect_file_dir, $db_connect_file_name, 10,'server',$folder=False);
    require_once($db_connect_path);
	connectToFootieDb(); //use your own function's name.
}
/* [END DB CONFIG] */

$rotaryJS = FindInParentDir(getcwd(), 'rotarySwitch/includes/rotarySwitch_3pos.js', 10,'url',$folder=False);
$rotaryConfig = FindInParentDir(getcwd(), 'rotarySwitch/config.php', 10,'server',$folder=False);
//rotary switch plugin
require($rotaryConfig);


//queries

		//reset attendence if new game
		$noGameSet = False;
		$currGameQ = "SELECT * FROM `currentGame`";
		$currGameQ = mysql_query($currGameQ) or die(mysql_error());		
		while($row = mysql_fetch_array($currGameQ,MYSQL_BOTH)){
			$currGame=(string) strtotime($row['eventDate']);  //stored as epoch value
		}
		if($currGame<$today[0]){ //game has passed, purge attendies
			$purgeRollCallQ = "DELETE FROM `rollcall`";
			$purgeRollCallQ = mysql_query($purgeRollCallQ) or die(mysql_error());
			$noGameSet = True;
		}
		
		//get all game dates, and determine which one is next!
		$allGameTimesQ = "SELECT * FROM `schedule`";
		$allGameTimesQ = mysql_query($allGameTimesQ) or die(mysql_error());
		while($row = mysql_fetch_array($allGameTimesQ,MYSQL_BOTH)){
			$allGameTimes[$row['opponent']]=(string) strtotime($row['day']);  //stored as epoch value
			$allGameFeeNames[$row['feeName']]=(string) strtotime($row['day']);  
		}
		$allOpponents=array_flip($allGameTimes);
		$allFeePayers = array_flip($allGameFeeNames);
		arsort($allGameTimes);
		arsort($allGameFeeNames);
		$gameCounter=0;
		foreach($allGameTimes as $team => $time){
			if($today[0]<$time){
				$nextGameDate=(string)$time;
			}
		}
		foreach($allGameFeeNames as $player => $time){
			if($today[0]<$time){
				$nextFeePayer=$player;
			}
		}

		//update the currentDate
		if($noGameSet){
			$query = "UPDATE  currentGame SET  `eventDate` =  FROM_UNIXTIME($nextGameDate)";
			$result = mysql_query($query) or die(mysql_error());
		}

		$nextOpponent= $allOpponents[(string)$nextGameDate];

		//get all the player names
		$allPlayersQ= "SELECT `name` FROM `players`";
		$allPlayersQ = mysql_query($allPlayersQ) or die(mysql_error());
		while($row = mysql_fetch_array($allPlayersQ)){
			$allPlayers[]=$row[0];  //stored as epoch value
		}

		//get all players registered for the next, upcoming game
		function getAttendingPlayers(){
			global $nextGameDate;
			$playersComing=array();
			$subs=array();
			$inPlayers=array();
			$outPlayers=array();
			$rollCallQ= "SELECT name,status,sub FROM rollcall";
			$rollCallQ = mysql_query($rollCallQ) or die(mysql_error());
			while($row = mysql_fetch_array($rollCallQ)){
				if($row['sub']){ //if a sub is listed, he/she is confirmed in
					$subs[]=$row['name'];}
				else{
					if($row['status']=="left") { //left implies player is in!
						$inPlayers[]=$row['name'];
					}
					if($row['status']=="right"){
						$outPlayers[]=$row['name'];
					}
				}
			}
			return array($inPlayers,$outPlayers,$subs);
		}

	//time & date functions
	function getNiceDuration($durationInSeconds) {
	  $duration = '';
	  $days = floor($durationInSeconds / 86400);
	  $durationInSeconds -= $days * 86400;
	  $hours = floor($durationInSeconds / 3600);
	  $durationInSeconds -= $hours * 3600;
	  $minutes = floor($durationInSeconds / 60);
	  $seconds = $durationInSeconds - $minutes * 60;

	  if($days > 0) {
	    $duration .= '<span style="font-size:300%">'. $days . '</span> days <br/>';
	  }
	  if($hours > 0) {
	    $duration .= '<span style="font-size:300%">' . $hours . '</span>  hours <br/>';
	  }
	  if($minutes > 0) {
	    $duration .= '<span style="font-size:300%">' . $minutes . '</span>  minutes <br/>';
	  }
	  if($seconds > 0) {
	    $duration .= '<span style="font-size:300%"> ' . $seconds . '</span> seconds <br />	';
	  }
	  return $duration;
	}

	//server funcs
	function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? ''
		: ($_SERVER["HTTPS"] == "on") ? "s"
		: "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}

?>