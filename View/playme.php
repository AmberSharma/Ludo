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
	var chances = new Array();
    var i = 0; 
    var message1 = "Its a Six take a turn Again!!!";
    var turn = 1;
    var droppedElementArrayIndex = 0;
    var droppedElementArray = new Array();
    var position = new Array();
    var visibleposition = new Array();
function dragdrop()
{
	
        $( ".draggable2" ).draggable({ revert: "invalid" });

        $( ".droppable" ).droppable({
                activeClass: "ui-state-hover",
                hoverClass: "ui-state-active",
                
                drop: function( event, ui ) {
					
					dicevalue = (chances[$( this ).attr('id').charAt(($( this ).attr('id')).length -1)]);
					presentposition = (visibleposition[$(ui.draggable).attr("id").charAt($(ui.draggable).attr("id").length -1) - 1]);
					//alert($(ui.draggable).attr("id"));
					alert(presentposition);
					if(presentposition == 0)
					{
						alert(dicevalue);
						if(dicevalue != 6 && dicevalue != 1)
						{
							//self.location.reload();
							$('#toPopup div.close').trigger("click");
							alert("Wrong Move Buddy!!!!");
							turn -=1;
							generateContent();
							$("a.topopup").click();
							
							//$((ui.draggable).attr("id")).draggable({ revert: true });
							return false;
						}
						else
						{
							$( this ).addClass( "ui-state-highlight" ).find( "p" ).html( "Dropped!" );
							$(this).droppable("disable");
							droppedElementArray[droppedElementArrayIndex ++] = ui.draggable.attr("id");
						}
					}
					else
					{
						$( this ).addClass( "ui-state-highlight" ).find( "p" ).html( "Dropped!" );
						$(this).droppable("disable");
						droppedElementArray[droppedElementArrayIndex ++] = ui.draggable.attr("id");
					}
                }
                
        });
}

    
function animateRoll(times)
{
    times = times || 1;
    var roll = generateRoll(1);
    drawRoll(roll);
    if (times > 10)
    {
		droppedElementArrayIndex = 0;
		droppedElementArray.splice(0, droppedElementArray.length);
		
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
        
        for(var k =1 ; k < 5 ; k ++)
        {
			position[k-1] = $("#"+image+k).closest("td").attr("id");
			visibleposition[k-1] = isNaN(position[k-1]) ? 0 : position[k-1];	
			
		}
    var data = "<div style='min-width: 200px;float:left'>";
    data += "<table border='1' cellpadding='10' cellspacing='10'>";
    data += "<tr>";
    data += "<th colspan='2'>Its' Me</th>";
    data += "<td><img id='"+image+"1' class='draggable2 ui-widget-content playerdropped' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img id='"+image+"2' class='draggable2 ui-widget-content playerdropped' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img id='"+image+"3' class='draggable2 ui-widget-content playerdropped' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "<td><img id='"+image+"4' class='draggable2 ui-widget-content playerdropped' src='../images/"+ image + (j++) +".png' height='30' width='30' /></td>";
    data += "</tr><tr>";
    data += "<th colspan='2'>Position</th>";
    
    data += "<td>"+ visibleposition[0] + "</td>";
    data += "<td>"+ visibleposition[1] + "</td>";
    data += "<td>"+ visibleposition[2] + "</td>";
    data += "<td>"+ visibleposition[3] + "</td>";
    data += "</tr>";
    data += "<tr>";
    data += "<th colspan='3' >Points</th>";
    data += "<th colspan='3' >Player</th>";
    data += "</tr>";
    
    
    
    
    for(var k =0 ; k < chances.length;k ++)
        {
            data += "<tr>";
            data += "<td colspan='3'>"+ chances[k] + "</td>";
            data += "<td id='droponme_"+k+"'colspan='3' class='droppable ui-widget-header' style='border:1px solid red;' >-</td>";
            data += "</tr>";
        }
    data += "</table>";
    data += "</div>";
    data += "<div style='float:right;width:200px;margin:50px;'>";
    data += "<a href='javascript:void(0)' onclick='moveplayers(0)'><img src='../images/okdone.png' height='100' width='100'></img></a>"
    data += "</div>";
    $("#popup_content").html(data);
    dragdrop();
    
}
function moveplayers(i)
{
	if(i < chances.length)
	{
		if(droppedElementArray.length == 0)
		{
			alert("What was That!!! Plz Choose a player to move" );
		}
		/*else if(isNaN(droppedElementArray[i]))
		{
			if(chances[i] != 6 || chances[i] != 1)
			{
				alert("Wrong Player to Move!!!");
			}
		}*/
		else
		{
			//alert(chances);
			//alert(position);
			//alert(droppedElementArray.length);
			//alert(chances.length);
			if(chances.length == droppedElementArray.length)
			{
				$('#toPopup div.close').trigger("click");
				elementposition = isNaN(position[droppedElementArray[i].charAt(droppedElementArray[i].length-1) - 1]) ? -2 : position[droppedElementArray[i].charAt(droppedElementArray[i].length-1) - 1];
				setTimeout("moveplayerstepwise("+elementposition+",'"+i+"')", 500);
				
				//chances = new Array();
			}
		}
		setTimeout("moveplayers("+(i+1)+")", 5000);
	}
	else
	{
		$('#toPopup div.close').trigger("click");
	}
}

function moveplayerstepwise(elementposition , i)
{
	//alert(elementposition);
	//alert(chances[i]);
	if(elementposition == -2)
	{
		elementposition = droppedElementArray[i].charAt(0) + droppedElementArray[i].charAt(droppedElementArray[i].length -1);
	}
	//alert(elementposition);
	if(elementposition < chances[i] || isNaN(elementposition))
	{
		$("#"+elementposition).html("&nbsp;");
		if(isNaN(elementposition))
			elementposition = 0;
		else
			elementposition += 1;
		$("#"+elementposition).html("<img src='../images/"+droppedElementArray[i]+"' height='20' width='20' id='"+droppedElementArray[i]+"' />");
		setTimeout("moveplayerstepwise("+elementposition+",'"+i+"')", 500);
	}
	else
	{
		chances = new Array();
	}
}

</script>
<style>
body
{
	background-image:url('../images/background1.jpg') ;
	background-repeat:no-repeat;
	background-size:100% 100%;
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
table.fixedtable
{ 
	table-layout:fixed; 
}
table.fixedtable td 
{ 
	overflow: hidden; 
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
<table border="1" width="95%" height="95%" cellpadding="0" cellspacing="0" style="text-align: center; white-space: normal;margin:2%;margin-left:2.3%;margin-top:1.8%;" class="fixedtable">
<tr>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0" class="fixedtable">
		<tr>
			<td>
			</td>
			<td id="g1">
				<a href="javascript:void(0);" ><img src="../images/green1.png" height="30" width="30" id="green1"/></a>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="g2">
				<img src="../images/green2.png" height="30" width="30" id="green2"/>
			</td>
			<td>
			</td>
			<td id="g3">
				<img src="../images/green3.png" height="30" width="30" id="green3"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="g4">
				<img src="../images/green4.png" height="30" width="30" id="green4"/>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
	<td id="<?php echo '10';?>">
	ab
	</td>
	<td id="<?php echo '11';?>">
	ab
	</td>
	<td id="<?php echo '12';?>">
	ab
	</td>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0" class="fixedtable">
		<tr>
			<td>
			</td>
			<td id="r1">
				<img src="../images/red1.png" height="30" width="30" id="red1"/>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="r2">
				<img src="../images/red2.png" height="30" width="30" id="red2"/>
			</td>
			<td>
			</td>
			<td id="r3">
				<img src="../images/red3.png" height="30" width="30" id="red3"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="r4">
				<img src="../images/red4.png" height="30" width="30" id="red4"/>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
</tr>
<?php
$g = 9 ;$r = 48 ;$m = 2;
for($i = 0 ; $i < 5 ; $i ++)
{
?>
<tr>
	<td id="<?php echo $g ; ?>">
	ab
	</td>
	<td id="<?php echo 'r' . ($r + (2 * $m) - 1); ?>">
	ab
	</td>
	<td id="<?php echo ($g + ($m * 2)); ?>">

	
	ab
	</td>
</tr>
<?php
$g -- ; $r --;$m ++;
}
?>
<tr>
<?php
$g = -1;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g ; ?>">
	ab
	</td>

<?php
$g ++;
}
?>
<td rowspan="3" colspan="3">
ab
</td>
<?php
$g = 18;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g; ?>">
	ab
	</td>
	

<?php
$g ++;
}
?>
</tr>
<tr>
<?php
$g = 50;
for($i = 0 ; $i < 6 ; $i ++)
{
	if($i == 0)
	{
?>

	<td id="<?php echo $g; ?>">
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
$g = 24;$b = 55;
for($i = 0 ; $i < 6 ; $i ++)
{
	if($i == 5)
	{
?>

	<td id="<?php echo $g; ?>">
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
$g = 49;
for($i = 0 ; $i < 6 ; $i ++)
{
?>

	<td id="<?php echo $g; ?>">
	ab
	</td>
	

<?php
$g --;
}
?>
<?php
$g = 30;
for($i = 0 ; $i < 6 ; $i ++)
{
?>


	<td id="<?php echo $g; ?>">

	
	ab
	</td>
	

<?php
$g --;
}
?>
</tr>
<tr>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0" class="fixedtable">
		<tr>
			<td>
			</td>
			<td id="y1">
				<img src="../images/yellow1.png" height="30" width="30" id="yellow1"/>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="y2">
				<img src="../images/yellow2.png" height="30" width="30" id="yellow2"/>
			</td>
			<td>
			</td>
			<td id="y3">
				<img src="../images/yellow3.png" height="30" width="30" id="yellow3"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="y4">
				<img src="../images/yellow4.png" height="30" width="30" id="yellow4"/>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
	<td id="<?php echo '43';?>">
	ab
	</td>
	<td id="<?php echo 'y55';?>">
	ab
	</td>
	<td id="<?php echo '31';?>">
	ab
	</td>
	<td rowspan="6" colspan="6">
	<table border="1" style="text-align: center;margin:8%;margin-left:25%;" width="50%" height="50%" cellpadding="0" cellspacing="0" class="fixedtable">
		<tr>
			<td>
			</td>
			<td id="b1">
				<img src="../images/blue1.png" height="30" width="30" id="blue1"/>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td id="b2">
				<img src="../images/blue2.png" height="30" width="30" id="blue2"/>
			</td>
			<td>
			</td>
			<td id="b3">
				<img src="../images/blue3.png" height="30" width="30" id="blue3"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td id="b4">
				<img src="../images/blue4.png" height="30" width="30" id="blue4"/>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</td>
</tr>
<?php
$g = 42 ;$m = 5;$n =54;
for($i = 0 ; $i < 5 ; $i ++)
{
?>
<tr>
	<td id="<?php echo $g; ?>">
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
	<td id="<?php echo ($g -1); ?>">	
<?php
}
?>
	ab
	</td>
	<td id="<?php echo ($g - ($m * 2)); ?>">
	ab
	</td>
</tr>
<?php
$g -- ;$m --;$n --;
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
