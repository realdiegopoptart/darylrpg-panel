<?php 
include 'includes/config.php'; 
include 'includes/header.php';
checkForLogin();

if(isset($_GET['id']))
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../pages/index.php">';    
	exit;	
}

if(isset($_GET['searchuser']))
{
	$getidquery = $con->prepare("SELECT user_id FROM users WHERE `user_name` LIKE :user_name");
	$getidquery->bindValue(":user_name", $_GET['searchuser'], PDO::PARAM_STR);
	$getidquery->execute();
	$searchedIdFetch = $getidquery->fetch();

	$searchedId = $searchedIdFetch['user_id'];
	$query = $con->prepare("SELECT * from users WHERE user_id = $searchedId");
	$query->execute();
	$sData = $query->fetch();

	if($getidquery->rowCount() > 0)
	{
		// do nothing
	}
	else
	{
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=invalidplayer.php">';
	}

	if($query->rowCount() == 0)
	{
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=invalidplayer.php">';
	}
}
?>


  	<div class="ui container">
      <div class="ui padded grid">
        <div class="sixteen wide column">
          

<?php
	$banreasonquery = $con->prepare("SELECT * FROM banned WHERE user_id = {$sData['user_id']}");
	$banreasonquery->execute();
	$banreason = $banreasonquery->fetch();
?>
    <div class="ui message">

<h2 class="ui center aligned icon header">
<?php

	$playerskin = $sData['skin_id'];

	if($sData['job_id'] != 0 || $sData['duty'] != 0)
		$playerskin = $sJob['skin_id2'];

	echo '<img class="circular icon" style="width: 75px;" src="assets/skin/heads/Skin_'.$playerskin.'.png" class="ui small centered image">';
?>
  <?php echo $sData['user_name']; ?>
    <div class="ui segments">
    <div class="ui segment">

		<div class="ui grey tiny basic horizontal label"><?php echo 'id: '.$sData['user_id']; ?></div>
	    <?php 
	        if($sData['isonline'] == 1)
	        {
	            echo '<div class="ui green tiny basic horizontal label">Online</div>';
	        }
	        else
	        {
	            echo '<div class="ui red tiny basic horizontal label">Offline</div>';
	        }
	    ?>
		<?php
		if($banreasonquery->rowCount() != 0)
		{
		    echo 
		    '<div class="ui red tiny basic horizontal label">banned on <strong>'.$banreason['ban_date'].' for <q>'.$banreason['ban_reason'].'</div>';
		    }
		?>

	  	<?php
	  	if($sData['admin_lvl'] > 0 || $sData['helper_level'] == 1)
	  	{
	  		$adminlvl;

	  		if($sData['helper_level'] == 1)
	  		{
	  			$adminlvl = "Helper";
	  		}

	  		switch($sData['admin_lvl']) 
		    {
		    	case 1:
		            $adminlvl = "Moderator";
		            break;
		        case 2:
		            $adminlvl = "Admin"; 
		            break;
		        case 3:
		            $adminlvl = "Senior Admin";
		            break;
		        case 4:
		            $adminlvl = "Manager";
		            break;
		        case 5:
		            $adminlvl = "Server Leader";
		            break;
		        case 6:
		            $adminlvl = "Director";
		            break;
		        case 7:
		            $adminlvl = "Owner";
		            break;
		        case 8:
		            $adminlvl = "Community Leader";
		            break;	
		    };


	  		echo '<div class="ui red tiny basic horizontal label">'.$adminlvl.'</div>';
	  	}
	    ?>

    </div>
</h2>

</div>
</div>
  </div>
        <div class="column">

            <div role="list" class="ui list">

    </div>
    <div class="column">
        <div role="list" class="ui list">



    </div>
</div>



<div class="ui grid">

  <div class="five wide column">

	<table class="ui celled striped table">
		<thead>
			<tr>
				<th colspan="2">
				Certificates
				</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td class="collapsing"><i class="car icon"></i> Drivers License </td>
				<td> <?php echo($sData['gun_license']) ? ("Yes") : ("No") ?> </td>
			</tr>

			<tr>
				<td class="collapsing"><i class="user secret icon"></i> Gun License </td>
				<td> <?php echo($sData['gun_license']) ? ("Yes") : ("No") ?> </td>
			</tr>
		
			<tr>
				<td class="collapsing"><i class="plane icon"></i> Pilot License </td>
				<td><?php echo($sData['air_license']) ? ("Yes") : ("No") ?></td>
			</tr>
		</tbody>
	</table>

  </div>


  <div class="five wide column">

	<table class="ui celled striped table">
		<thead>
			<tr>
				<th colspan="2">
				Networth
				</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td class="collapsing"><i class="money bill alternate outline secret icon"></i> Cash </td>
				<td> <?php echo '$'.number_format($sData['money']); ?> </td>
			</tr>

			<tr>
				<td class="collapsing"><i class="university icon"></i> Bank </td>
				<td> TBA </td>
			</tr>
		
			<tr>
				<td class="collapsing"><i class="plane icon"></i> Total </td>
				<td> TBA </td>
			</tr>
		</tbody>
	</table>

  </div>


  <div class="five wide column">

  <table class="ui celled striped table">
		<thead>
			<tr>
				<th colspan="2">
				Activity
				</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td class="collapsing"><i class="calendar alternate outline icon"></i> Last Online </td>
				<td> <?php echo $sData['last_login']; ?> </td>
			</tr>

			<tr>
				<td class="collapsing"><i class="signal icon"></i> Level </td>
				<td> <?php echo $sData['level']; ?> </td>
			</tr>
		
			<tr>
				<td class="collapsing"><i class="clock outline icon"></i> Total Playtime </td>
				<td><?php echo $sData['hours_online']; ?> Hours</td>
			</tr>
		</tbody>
	</table>

  </div>
  
</div>


	<div class="ui horizontal section divider">
		PLAYER GROUPS
		</div>
<?php
$query = $con->prepare("SELECT g.group_id, g.name, g.type, g.prefix FROM group_members m INNER JOIN groups g ON (g.group_id = m.groupid) WHERE m.user_id = {$sData['user_id']};");
$query->execute();

?>

<?php
  if($query -> rowCount() == 0)
  {
    echo "<center><h3><strong>This player hasn't joined any groups yet.</strong></h3></center>";
  }
  else
  {
echo '<table class="ui table">
    <thead class="">
        <tr class="">
            <th class="">Type</th>
            <th class="">Name</th>
            <th class="">Rank</th>
        </tr>
    </thead>
    <tbody class="">';

	while($row = $query -> fetch())
	{
		$groupId = $row['group_id'];
		$grouprankquery = $con->prepare(
				"SELECT r.rank_level AS level, r.rank_name AS title 
				FROM group_members m 
				INNER JOIN group_ranks r ON (r.rank_level = m.user_rank AND r.group_id = m.groupid)
				WHERE m.user_id = {$sData['user_id']} AND m.groupid = $groupId");
		$grouprankquery->execute();
		$getGroupRank = $grouprankquery->fetch();

			switch($row['type']) 
			{
				case 1:
				case 6:
				case 9:
					$a = '<div class="ui blue tiny basic horizontal label">Government</div>';
					break;
				case 13:
				case 7:
					$a = '<div class="ui grey tiny basic horizontal label">Business</div>';
					break;
				case 2:
				case 3:
				case 4:
				case 5:
				case 8:
				case 12:
					$a = '<div class="ui grey tiny basic horizontal label">Criminal</div>';
					break;
			}

		echo '<tr class="">
				<td class="one wide">
					'.$a.'
				</td>
				<td class="five wide">
					<h4 class="ui header">
						<div class="content"><a href="group.php?groupid='.$row['group_id'].'">'.$row['name'].'</a>
							<div class="sub header">'.$row['prefix'].'</div>
						</div>
					</h4>
				</td>
				<td class="">'.$getGroupRank['title'].'</td>
			</tr>';
		}
  }
  ?>
    </tbody>
</table>

<?php
if($_SESSION['playeradmin'] >= 1 || $sData['user_id'] == $_SESSION['uID']) 
{
	
    $queryp = $con->prepare("SELECT r.type, r.reason, r.admin_id FROM record r INNER JOIN users p ON (r.user_id = p.user_id) WHERE p.user_id = {$sData['user_id']} ORDER BY r.time;");
    $queryp->execute();	
	
	echo '<div class="ui horizontal section divider">
	ADMINISTRATIVE ACTIONS
	</div>';
		
	
	if($queryp -> rowCount() == 0)
	{
		echo '<div class="ui negative message">
	  <div class="header">
		No punishment history found
	  </div>
		</div>';
	}
	else if($queryp -> rowCount() != 0)
	{
		echo '<table class="ui table">
		<thead class="">
		  <tr>
			<th class="">Type</th>
			<th class="">Reason</th>
			<th class="">Admin</th>';
			if($_SESSION['playeradmin'] >= 2)
			{
				echo '<th class="">Options</th>';
			}

		echo '</tr>
		</thead>
		<tbody>';

		while($row = $queryp -> fetch())
		{
			$adminid = $row['admin_id'];
			echo '<tr>
			<td>';
				switch($row['type']) 
				{
					case "Jail":
						echo '<a class="item">
						<div class="ui yellow horizontal label">Jail</div>
						</a>';
						break;
					case "Warn":
						echo '<a class="item">
						<div class="ui yellow horizontal label">Warning</div>
						</a>';      
						break;
					case "Kick":
						echo '<a class="item">
						<div class="ui yellow horizontal label">Kick</div>
						</a>';      
						break;
					case "Temp Ban":
						echo '<a class="item">
						<div class="ui orange horizontal label">Temp Ban</div>
						</a>';  
						break;
					case "Ban":
						echo '<a class="item">
						<div class="ui red horizontal label">Full Ban</div>
						</a>';    
						break;
					case "Mute":
						echo '<a class="item">
						<div class="ui yellow horizontal label">Mute</div>
						</a>';     
						break;
					default:
						echo '<center><a class="item">
						<div class="ui grey horizontal label">Unknown</div>
						</a></center';     
						break;
				}

			echo '</td>
			<td>'. $row['reason'].'</td>
			<td>';
			$adminname = $con->prepare("SELECT user_name FROM users WHERE user_id = $adminid");
			$adminname->execute();
			$adminName = $adminname->fetch();
			echo '<a href="player.php?searchuser='.$adminName['user_name'].'" >'.$adminName['user_name'] . `</td>`;
			if($_SESSION['playeradmin'] >= 2)
			{
				echo '<td><a href="admin.php?action=removerecord&id='.$row['admin_id'].'&userid='.$sData['user_id'].'&type='.$row['type'].'&reason='.$row['reason'].'">Expunge</a></td>';
			}
			echo `</tr>`;
		}

		echo '</tbody>
		<tfoot>
		</tfoot>
		</table>';
	}

}
?>
            <div class="ui hidden divider"></div>
            <div class="ui divider"></div>
            <footer>Axiania RPG</footer>
<?php
	include 'includes/footer.php'; 
?>


<script>
$('.mini.modal').modal('show');
</script>