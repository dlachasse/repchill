<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	$today = getdate();
	$rollCall=True;
	//include('./../incs/kint/kint.class.php');
	require_once('./kraken_tools/footie_funcs.inc');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>FC Kraken: Footie Deets</title>
	<link href="./kraken_tools/jquery-ui-1.8_custom.css" rel="stylesheet" type="text/css" />
	<link href="./kraken_tools/footie.css" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Tulpen+One' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Monoton' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js'></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./kraken_tools/jquery.masonry.min.js"></script>
	<script type="text/javascript" src="./kraken_tools/dialog.js"></script>
	<script src="http://www.youtube.com/player_api"></script>
	<script type="text/javascript" src="./kraken_tools/footie_funcs.js"></script>
	<script type="text/javascript" src="./rotarySwitch/includes/jquery_transit.js"></script>
	<script type="text/javascript" src="./rotarySwitch/includes/hover_intent.js"></script>
	<script type="text/javascript" src="./kraken_tools/playSound.js"></script>

	<script type="text/javascript">
	//execute only once full page has been processed
	$(document).ready(function(){ 
		//setup rotarySwitches
		<?php
		echo "$.getScript(\"$rotaryJS\", function(){";
		?>
    		rotarySetup();
    	});
		//setup masonry floaty items
		var $container = $('#container_masonry');
		$container.imagesLoaded(function(){
		  $container.masonry({
		    itemSelector : '.item',
		    columnWidth : 20
		  });
		});	
	});
	</script>
</head>

<body><div class="css-grd">

	<div id="maincontainer">

	<div id="topsection"><div class="innertube"><h1><!--title here--></h1></div></div><!--top section-->
	
	<div id="contentwrapper">
		<div id="contentcolumn">
			<div id="container_masonry" class="clearfix masonry" style="position:relative"><!-- masonry -->
				<!-- team -->
				<div class="item"><div id="team"><h1>FC Kraken!</h1></div></div>
						
				<?php

				//next game
				echo '<div class="item"><div id="nextGame">The next game begins at:<br/> '.date('l jS \of F Y h:i:s A',$nextGameDate)."<br/>
						vs. ".$nextOpponent."</div></div>\n";
				
				//today
				echo '<div class="item"><div id="today">Today is: '.$today['weekday'].', '.$today['mon'].'/'.$today['mday'].'/'.$today['year'].'</div></div>';
				
				//countdown
				echo '<div class="item"><div id="countdown">
						<div style="font-weight: bolder;font-size:200%;margin:auto;text-align:center">COUNTDOWN</div>'.getNiceDuration($nextGameDate-$today[0]).' until the next game!'.'</div></div>';
				?>

				<!-- schedule -->	
				<div class="item">
					<div id="fullsched">
						<div style="font-weight: bolder;font-size:200%;margin:auto;text-align:center"><a href="http://portland-soccerplex.ezleagues.ezfacility.com/schedule.aspx">Full Schedule!</a></div>
					</div>
				</div>


				<!-- kraken pics -->
				<?php
				$numKraken = mt_rand(10,20);
				$i=0;
				while ($i <= $numKraken) {
					$angle= mt_rand(0,359);
					echo "<div class=\"item\">
							<img style=\"transform:rotate($angle".'deg'.");
										 -moz-transform:rotate($angle".'deg'.");
										 -ms-transform:rotate($angle".'deg'.");
										 -webkit-transform:rotate($angle".'deg'.");
										  -o-transform:rotate($angle".'deg'.");
										\" 
									id=\"kraken$i\" alt=\"kraken$i\" src=\"./kraken_tools/images/lilkraken.png\" width=\"40\" height=\"40\" />
							</div>";
					$i+=1;
				}
				?>

				<!-- kitty -->
				<div class="item">
					<div id="transborder">
						<img id="cat" alt="cat" src="./kraken_tools/images/krakkitty.jpeg" width="250" height="188" />
					</div> 
				</div>

				<!-- RELEASE THE KRAKEN -->
				<div class="item">
					<div class="transborder">
							<div id="embed-code">
							    <iframe id="player" width="250" height="188" src="http://www.youtube.com/embed/7SqC_m3yUDU?enablejsapi=1" seamless="seamless" ></iframe>​
							</div>
					</div>
				</div>
			</div><!--container_masonry-->
		</div><!--content col-->
	</div><!-- content wrapper -->

	<!--right col -->
	<div id="rightcolumn">
		<div id="rollCall">	
			<form method="POST" name="rollcall" id="rollcall">
				<h3 style="font-size:350%">Roll Call!</h3>
					<?php
					$playersComing= getAttendingPlayers(); //get attending players last because me may be updating the list if the form was just submitted
					echo '<span style="font-variant:caps;font-weight:bolder">'.(count($playersComing[0])+count($playersComing[2])).' players have already confirmed their attendance for the next game! </span><br/><br/>'."\n\n";
					echo '<span style="font-variant:caps;font-weight:bolder">'.(count($playersComing[1])).' lame wads aren\'t coming!</span><br/><br/>'."\n\n";
					//ADD STD PLAYERS
					foreach ($allPlayers as $player) { //all players defined in footie_funcs.inc
						echo "<div id=\"$player\" class=\"player\">";
						createRotarySwitch($player,true);
						if($nextFeePayer == $player){
							echo  "<img id=\"fee\" alt=\"ref fee duty, 9 bucks!\" src=\"./kraken_tools/images/fee.png\" width=\"40\" height=\"82\" />
									<p>Bring $9 for ref fees!</p>";
						}
						echo "<br/><label for=\"rotaryContainer_$player\">$player</label></div>\n";
					}
					//ADD SUBS
					foreach ($playersComing[2] as $player) { //[2] index = subs
						if($player){
							echo "<div class=\"clear\" id=\"$player\">\n".
								 	"<div id=\"subButtonLabel\">Sub: </div>".'  '."\n".
								 	"<input class=\"subButtonsText\" readonly=\"readonly\" type=\"text\" id=\"$player\" name=\"$player\" value=\"$player\" />\n".
								 	"<button class=\"subButtons\" onclick=\"RemoveSub('$player')\" id=\"addSub\">Remove Sub</button>".
								 "</div><br/><br/>";
						}
					}
					?>								
			<input type="hidden" name="submitted" value="TRUE" />
		</form>
		<br/><br/>
			<div id="addPlayer">
				<input id="sub" type="text" class="subButtons" name="sub" />
				<button class="subButtons" onclick="AddSub()">Add Sub</button>
			</div>
			<div>
				<br/><br/><br/><p>Note: Standard players must be signed in before subs can be added</p>
			</div>
		</div>
	</div><!--right col -->

	</div><!--main container-->

<div style="visibility:hidden">

	<div id="dialog-confirm" title="RollCall!">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
			<span id="alertText">These items will be permanently deleted and cannot be recovered. Are you sure?</span>
		</p>
	</div>

</div><!-- End demo -->

</div></body>
</html>