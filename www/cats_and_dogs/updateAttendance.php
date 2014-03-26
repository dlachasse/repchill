<?php

$returnMsg='';

require_once('./../../db_connect_info.inc');
connectToFootieDb();

$player = mysql_real_escape_string($_POST['player']);
$attending = mysql_real_escape_string($_POST['attending']);
$nextGameDateUgly = mysql_real_escape_string($_POST['nextGameDateUgly']);

//if attending, add to DB!
if($attending){
	//add person to the game
	$query = "INSERT INTO rollcall (name,game) VALUES ('".$player."','".$nextGameDateUgly."')";
	$result = mysql_query($query) or die(mysql_error());
	$returnMsg.=$player.', you\'ve successfully checked in for the big game!  If you\'re not '.$player.' then please de-select this person\'s name';

}
//not attending!
else{
	//check if person is already attending this game.
	$query = "SELECT name FROM rollcall WHERE `game`='".$nextGameDateUgly."'";
	$result = mysql_query($query) or die(mysql_error());

	//delete if that person is attending
	if(count($result)){
		$query = "DELETE FROM rollcall WHERE `game`='".$nextGameDateUgly."' AND `name`='".$player."'";
		$result = mysql_query($query) or die(mysql_error());
		$returnMsg.=$player.', you\'ve successfully checked out of the next game!  Too bad :( .  If you\'re not '.$player.' then please re-select this person\'s name';
	}
}

//return feedback to the page
echo trim($returnMsg);

?>