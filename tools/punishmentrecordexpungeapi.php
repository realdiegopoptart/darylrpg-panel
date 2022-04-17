<?php
include '../includes/config.php';
if(isset($_GET['playername']))
{
	$unlinkquery = $con->prepare("UPDATE player SET playerDiscord = -1 WHERE `playerId` = '$sesuID'");
	$unlinkquery->execute();
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';    
	exit;
}
else
{
	header("location:index.php");
}
?>