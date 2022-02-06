
<?php
$con = new PDO("mysql:host=localhost;dbname=asianiarpg", "root", "");
	
//session_start();
function checkForLogin()
{
	if(!isset($_SESSION['playername']))
	{
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';    
		exit;
	}
}
?>