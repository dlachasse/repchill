<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="css-grd" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>rotarySwitchExample-Simple</title>

<style>

.rotaryContainer{
    position: relative;
    display: inline-block;
    height: 50px;
    width: 50px;
}

.rotarySwitchBase img{
    height: 50px;
    width: 50px;
    margin-top: 0px;
    margin-left: 0px;
}

.rotarySwitchCap{
    position: absolute;
    top:0px;
    transform:rotate(0deg);
    -moz-transform:rotate(0deg);
    -ms-transform:rotate(0deg);
    -o-transform:rotate(0deg);
    -webkit-transform:rotate(0deg);
    z-index: 1;
}

.rotarySwitchCap img{
    height: 0px;
    width: 0px;
}

.rotarySwitchHover{
    position: absolute;
    top:0px;
    z-index: 2;
    margin-top: 0px;
    margin-left: 0px;
}
.rotarySwitchHover img{
    height: 50px;
    width: 50px;
}

.rotaryValue {
    position:absolute;
    visibility:hidden;
}

</style>

<script type="text/javascript" src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js'></script>
<!-- The follow two libraries must be used -->
<script type="text/javascript" src="./rotarySwitch/inlcudes/jquery-css-transform.js"></script>
<script type="text/javascript" src="./rotarySwitch/includes/hover_intent.js"></script>

<script>
$(window).load( function() {
    $.getScript('./rotarySwitch/includes/rotarySwitch_3pos.js', function(data, textStatus, jqxhr) {
        rotarySetup();
    })
});
</script>

    <div id="rotaryContainer_example" name="example" class="rotaryContainer" >
	    <div class="dbFlag"></div>    
	    <div class="rotarySwitchBase">
            <img src="./rotarySwitch/img/circle_toggle.png" />
        </div>
        <div id="fore_example" name="example" class="rotarySwitchCap" >
            <img src="./rotarySwitch/img/circle_toggle_cover.png" />
        </div>
        <div id="bub_center_example" name="example" class="rotarySwitchHover" >
            <img src="./rotarySwitch/img/bubble_center.png" />
        </div>
        <div id="bub_top_example" name="example" class="rotarySwitchHover" >
            <img src="./rotarySwitch/img/bubble_top.png" />
        </div>
        <div id="bub_left_example" name="example" class="rotarySwitchHover" >
            <img src="./rotarySwitch/img/bubble_left.png" />
        </div>
        <div id="bub_right_example" name="example" class="rotarySwitchHover" >
            <img src="./rotarySwitch/img/bubble_right.png" />
        </div>
        <input class="rotaryValue" type="text" id="input_example" />
    </div>

</head>

<body>

</body>
</html>
