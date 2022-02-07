<?php
include 'includes/config.php';
if(isset($_SESSION['playername']))
{
	unset($_SESSION['playername']);
	unset($_SESSION['playeradmin']);
	unset($_SESSION['uID']);
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';    
	exit;
}
else
{
	header("location:index.php");
}
?>