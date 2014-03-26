<?php

function updateAttendancePHP($player,$attending,$sub=0,$echo=True){
	//init vars
	$returnMsg='';

	//only process is subs have names >2 letters
	if(strlen($player)<1){
		echo 'Player name is too short!';
		break;
	}

	//check if person is already attending this game.
	$alreadyAttending = False;
	$query = "SELECT name FROM rollcall WHERE `name`=\"$player\"";
	$result = mysql_query($query) or die(mysql_error());
	while($row=mysql_fetch_array($result)){
		$alreadyAttending=True;
	}

	//if attending, add to DB!
	if($attending && !$alreadyAttending){
		//add person to the game
		$query = "INSERT INTO rollcall (name,sub) VALUES (\"$player\",\"$sub\")";
		$result = mysql_query($query) or die(mysql_error());
		$returnMsg.=$player.', you\'ve successfully checked in for the big game!  If you\'re not '.$player.' then please de-select this person\'s name';

	}
	//not attending!
	else{
		//delete if that person is attending
		if(!$attending){
			$query = "DELETE FROM rollcall WHERE `name`=\"$player\" AND `sub`=\"true\"";
			$result = mysql_query($query) or die(mysql_error());
			$returnMsg.=$player.', you\'ve checked out of the next game!  What the heck?!?!  Too bad :( .  If you\'re not '.$player.' then please re-select this person\'s name';
		}
	}
	//return feedback to the page
	if($attending){
		$attendanceMsg = 'Hell yea I am!';
	}
	else{
		$attendanceMsg = 'No, I\'ve converted lameness.  It\'s a sick, sick cult.  Members?  Just me ';
	}
	$returnMsg="You, kind sir or miss: $player<br/>
				You comin?: $attendanceMsg<br/>
				\n".$returnMsg;
	if($echo){
		echo trim($returnMsg);	
	}

}

require_once('./../../../db_connect_info.inc');

connectToFootieDb();

$player = mysql_real_escape_string($_GET['player']);
$attending = mysql_real_escape_string($_GET['attending']);
if($attending != 'true'){
	$attending=False;
}
$sub = mysql_real_escape_string($_GET['sub']);
$echo = mysql_real_escape_string($_GET['echo']);

updateAttendancePHP($player,$attending,$sub,$echo);

?>