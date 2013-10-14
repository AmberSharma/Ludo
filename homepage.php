<?php require_once "/var/www/SnakeandLadder/trunk/libraries/constant.php"; ?>
<script src="<?php echo SITE_URL;?>/js/jquery.tools.min.js"></script>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/homepage.css">
<html>
<head>

<style>
/* the overlayed element */

</style>
</head>
<body>
<div id="container">
<div style="width:10%"><a href="<?php echo SITE_URL ?>/View/bendrules.php" style="margin-left:40%;"><img src="images/bendrules.jpg" height='150' width='50'/></a></div>
<table cellspacing="0">
<tr>
<td>
<a href="<?php echo SITE_URL ?>/View/bendrules.php" ><img src="images/startgame.jpg" height='60' width='220'/></a>
</td>

</tr>
<tr>
<td>
<a href="#" ><img src="images/gamerules.jpg" rel="#mies1" height='60' width='220'/></a>
</td>

</tr>
</table>
</div>
<div class="simple_overlay" id="mies1">
<img src="images/therules.jpg" width='420' height='500'/>
<div class="details">
<pre>
<br />
<br />
<br />
<b>Step 1:</b> The aim of the game is to be the first player
to reach the end by moving across the board from square
1 to square 100.

<b>Step 2:</b> The game can be played in two ways either manual
or automatic player move.

<b>Step 3:</b> Each subsequent player must throw a dice to move
the player on his/her turn.

<b>Step 4:</b> If a player lands at the tip of the snake's head,
his or her marker slides down to the square at the snake's
tail.
 
<b>Step 5:</b> If a player lands on a square that is at the base
of a ladder, his or her marker moves to the square at the
top of the ladder and continues from there.
 
<b>Step 6:</b> Once any player reaches the top the game.
              
		The Game Ends!!!.
</pre>
  </div>
</div>
</body>
</html>
<script>
  $("img[rel]").overlay();
</script>
