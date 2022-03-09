<?php 
include 'includes/config.php'; 
include 'includes/header.php';
checkForLogin();

if(isset($_GET['id']))
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../pages/index.php">';    
	exit;	
}
?>


<div class="ui container">
	<div class="ui padded grid">
		<div class="twenty wide column">
          
			<div class="ui info message">

				<h2 class="ui center aligned icon header">
				  Searched user does not exist
				</h2>
				    <div class="ui segments">
				    <div class="ui segment">
					     	<center><form method="GET" action="player.php" class="ui large input">
    							<input type="text" placeholder="Try searching again..." name="searchuser" id="searchuser">
    						</form></center>
				    </div>

<?php
	include 'includes/footer.php'; 
?>