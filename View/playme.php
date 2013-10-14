<html>
<head>
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../js/jquery.tools.min.js"> </script>
<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery.ui.core.js"></script>
<script src="../js/jquery.ui.widget.js"></script>
<script src="../js/jquery.ui.mouse.js"></script>
<script src="../js/jquery.ui.draggable.js"></script>
<script src="../js/jquery.ui.droppable.js"></script>

<script type="text/javascript" src="../js/script.js"></script>
<script>
function dragdrop()
{
        $( ".draggable2" ).draggable({ revert: "invalid" });

        $( ".droppable" ).droppable({
                activeClass: "ui-state-hover",
                hoverClass: "ui-state-active",
                drop: function( event, ui ) {
                        $( this )
                                .addClass( "ui-state-highlight" )
                                .find( "p" )
                                        .html( "Dropped!" );
                }
        });
}
</script>

<script>
    var chances = new Array();
    var i = 0;
    var message1 = "Its a Six take a turn Again!!!";
    var turn = 1;
function animateRoll(times)
{
    times = times || 1;
    var roll = generateRoll(1);
    drawRoll(roll);
    if (times > 10)
    {
        var sum = checkRoll(roll);
        if(sum == 6)
            {
                chances[i ++] = sum;
                $("#message").fadeIn();
                $("#message").html("<span class='bubble'>"+message1+"</span>");
                $("#message").fadeOut(8000);
                return ;
            }
        else
            {
                chances[i ++] = sum;
                generateContent();
                i = 0;
                
                
            }
        
        return;
    }
    setTimeout('animateRoll(' + (times + 1) + ')', 200);
}
function generateRoll(dice)
{
   var arr = new Array();
    // return [ Math.floor(Math.random()*6) + 1, Math.floor(Math.random()*6) + 1 ]; -->
   for(var i = 0 ; i < dice ; i ++)
   {
           arr[i] = Math.floor(Math.random()*6) + 1 ; 
   }	
   return arr;
}
function drawRoll(die)
{
   for(var i = 0 ; i < die.length ; i ++)
   {
           var j = i + 1;
           document.getElementById('die'+(j)).innerHTML = '<img src="../images/Dice_' + die[i] +'.png" />';
   }

    // document.getElementById('die2').innerHTML = '<img src="../images/Dice_' + die2 +'.png" />'; 
}

function checkRoll(die)
{
   var sum = 0;
   for(var i = 0 ; i < die.length ; i ++)
   {
           sum += 	die[i];
   }
    return sum;
}
function generateContent()
{
    alert(turn);
    var image;
    var j = 1;
    var inside = 0;
    if(turn == 1)
        image = "green";
    else if(turn == 2)
        image = "red";
    else if(turn == 3)
        image = "blue";
    else
        image = "yellow";
    if(turn != 4)
        {
            turn ++;
            inside = 1;
        }
    if(turn == 4 && inside != 1)
        turn = 1;
    var data = "<table border='1' cellpadding='10' cellspacing='10'>";
    data += "<tr>";
    data += "<th colspan='2'>Its' Me</th>";
    data += "<td><img class='draggable2 ui-widget-content' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img class='draggable2 ui-widget-content' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img class='draggable2 ui-widget-content' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img class='draggable2 ui-widget-content' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "</tr><tr>";
    data += "<th colspan='2'>Position</th>";
    data += "<td>0</td>";
    data += "<td>0</td>";
    data += "<td>0</td>";
    data += "<td>0</td>";
    data += "</tr>";
    data += "<tr>";
    data += "<th colspan='3' >Points</th>";
    data += "<th colspan='3' >Player</th>";
    data += "</tr>";
    
    for(var k =0 ; k < chances.length;k ++)
        {
            data += "<tr>";
            data += "<td colspan='3'>"+ chances[k] + "</td>";
            data += "<td colspan='3' class='droppable ui-widget-header' style='border:1px solid red;'>-</td>";
            data += "</tr>";
        }
    data += "</table>";
    $("#popup_content").html(data);
    dragdrop();
    chances = new Array();
}
</script>
<style>
body
{
	
	border: 1px solid red;
}
#left
{
	height:100%;
	width:19%;
	float:left;
	border: 1px solid red;
}
#center
{
	height:100%;
	width:60%;
	float:left;
	border: 1px solid red;
	background-image:url("../images/ludoboard.png");
	background-size:100% 100%;
	background-repeat:no-repeat;
}
#right
{
	height:100%;
	width:19%;
	float:left;
	border: 1px solid red;
}
</style>
</head>
<body>
<div id="left">
    <div><div id='die1'></div></div>
    <div>
    <div id = "dicerollbutton">
            <a href="javascript:void(0)" onClick='animateRoll()' style="margin-left:9%;"><img src="../images/rolldice.jpg" height='60' width='220'/></a>
    </div>
    </div>
            <div><a href="#" class="topopup">Click Here Trigger</a></div>
</div>
	
<div id="center">
<table border="1" width="95%" height="95%" cellpadding="0" cellspacing="0" style="text-align: center; white-space: normal;margin:2%;margin-left:2.3%;margin-top:1.8%;">
<tr>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0">
		<tr>
			<td>
			</td>
			<td id="g1">
				<a href="javascript:void(0);" ><img src="../images/green1.png" height="30" width="30" /></a>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="g2">
				<img src="../images/green2.png" height="30" width="30" />
			</td>
			<td>
			</td>
			<td id="g3">
				<img src="../images/green3.png" height="30" width="30" />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="g4">
				<img src="../images/green4.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
	<td id="<?php echo '10,49,36,23';?>">
	ab
	</td>
	<td id="<?php echo '11,50,37,24';?>">
	ab
	</td>
	<td id="<?php echo '12,-1,38,25';?>">
	ab
	</td>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0">
		<tr>
			<td>
			</td>
			<td id="r1">
				<img src="../images/red1.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="r2">
				<img src="../images/red2.png" height="30" width="30" />
			</td>
			<td>
			</td>
			<td id="r3">
				<img src="../images/red3.png" height="30" width="30" />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="r4">
				<img src="../images/red4.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
</tr>
<?php
$g = 9 ;$r = 48 ;$b = 35 ;$y = 22;$k =0;$m = 2;
for($i = 0 ; $i < 5 ; $i ++)
{
?>
<tr>
	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
	ab
	</td>
	<td id="<?php echo 'r' . ($r + (2 * $m) - 1); ?>">
	ab
	</td>
	<td id="<?php echo ($g + ($m * 2)). ',' . $k . ',' . ($b + ($m * 2)) . ',' . ($y + ($m * 2)); ?>">

	
	ab
	</td>
</tr>
<?php
$k ++ ; $g -- ; $r --;$y --; $b --;$m ++;
}
?>
<tr>
<?php
$g = -1;$r = 38;$y = 12;$b = 25;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
	ab
	</td>

<?php
$g ++;$r ++;$y ++;$b ++;
}
?>
<td rowspan="3" colspan="3">
ab
</td>
<?php
$g = 18;$r = 5;$y = 31;$b = 44;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
	ab
	</td>
	

<?php
$g ++;$r ++;$y ++;$b ++;
}
?>
</tr>
<tr>
<?php
$g = 50;$r = 37;$y = 11;$b = 24;
for($i = 0 ; $i < 6 ; $i ++)
{
	if($i == 0)
	{
?>

	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
<?php
	}
	else
	{
?>
	<td id="<?php echo 'g'. $g; ?>">
<?php
	}
?>
	ab
	</td>
	

<?php
$g ++;
}
?>
<?php
$g = 24;$r = 11;$y = 37;$b = 55;
for($i = 0 ; $i < 6 ; $i ++)
{
	if($i == 5)
	{
?>

	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
<?php
	}
	else
	{
?>
	<td id="<?php echo 'b'. $b; ?>">
<?php
	}
?>
	ab
	</td>
	

<?php
$b --;
}
?>
</tr>
<tr>
<?php
$g = 49;$r = 36;$y = 10;$b = 23;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
	ab
	</td>
	

<?php
$g --; $r --; $y --; $b --;
}
?>
<?php
$g = 30;$r = 17;$y = 43;$b = 4;
for($i = 0 ; $i < 6 ; $i ++)
{
?>


	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">

	
	ab
	</td>
	

<?php
$g --; $r --; $y --; $b --;
}
?>
</tr>
<tr>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0">
		<tr>
			<td>
			</td>
			<td id="y1">
				<img src="../images/yellow1.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="y2">
				<img src="../images/yellow2.png" height="30" width="30" />
			</td>
			<td>
			</td>
			<td id="y3">
				<img src="../images/yellow3.png" height="30" width="30" />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="y4">
				<img src="../images/yellow4.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
	<td id="<?php echo '43,30,17,4';?>">
	ab
	</td>
	<td id="<?php echo 'y55';?>">
	ab
	</td>
	<td id="<?php echo '31,18,5,44';?>">
	ab
	</td>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0">
		<tr>
			<td>
			</td>
			<td id="b1">
				<img src="../images/blue1.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="b2">
				<img src="../images/blue2.png" height="30" width="30" />
			</td>
			<td>
			</td>
			<td id="b3">
				<img src="../images/blue3.png" height="30" width="30" />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="b4">
				<img src="../images/blue4.png" height="30" width="30" />
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
</tr>
<?php
$g = 42 ;$r = 29 ;$b = 16 ;$y = 3;$k =45;$m = 5;$n =54;
for($i = 0 ; $i < 5 ; $i ++)
{
?>
<tr>
	<td id="<?php echo $g . ',' . $r . ',' . $b . ',' . $y ; ?>">
	ab
	</td>
<?php
if($i != 4)
{
?>
	<td id="<?php echo 'y' . $n; ?>">
<?php
}
else
{
?>
	<td id="<?php echo ($g -1) . ',' . ($r - 1) . ',' . ($b - 1). ',' . $n ; ?>">	
<?php
}
?>
	ab
	</td>
	<td id="<?php echo ($g - ($m * 2)). ',' . ($r - ($m * 2)) . ',' . ($b - ($m * 2)) . ',' . $k; ?>">
	ab
	</td>
</tr>
<?php
$k ++ ; $g -- ; $r --;$y --; $b --;$m --;$n --;
}
?>
</table>
</div>
<div id="right">
    <div id="message"></div>
</div>

    
    <div id="toPopup"> 
    	
        <div class="close"></div>
       	<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
            <p>
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, 
            feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi 
            vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, 
            commodo Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque habitant morbi tristique 
            senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, 
            feugiat vitae, ultricies eget, tempor sit amet, ante. </p>
            <br />
            <p>
            Donec eu libero sit amet quam egestas semper. Aenean ultricies mi 
            vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, 
            commodo Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
            <p align="center"><a href="#" class="livebox">Click Here Trigger</a></p>
        </div> <!--your content end-->
    
    </div> <!--toPopup end-->
    
	<div class="loader"></div>
   	<div id="backgroundPopup"></div>
</body>
</html>
