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
		echo '<div class="ui red message">
		<div class="header">
		  Player not found
		</div>
		<p>This player does not exist or there was a typo.</p>
	  </div>';
	}

	if($query->rowCount() == 0)
	{
		echo '<div class="ui red message">
		<div class="header">
		  Something went wrong
		</div>
		<p>Could not load data, if this persits please contact a developer.</p>
	  </div>';
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

if($banreasonquery->rowCount() != 0)
{
    echo 
    '<div class="ui error message">
    	<div class="header">
    	<i class="icon exclamation triangle"></i>
        This player is currently banned
    	</div>
		    <ul class="list">
		    <li><strong>'.$sData['user_name'].'</strong> was banned on <strong>'.$banreason['ban_date'].'</strong> for <q>'.$banreason['ban_reason'].'</q></li>
		    </ul>
    </div>';
    }
?>
            <div class="ui message">

  	<?php echo $sData['user_name']; ?>
  	<div class="ui grey tiny basic horizontal label"><?php echo 'id: '.$sData['user_id']; ?></div>

  	<?php
  	if($sData['admin_lvl'] > 0 || $sData['helper_level'] == 1)
  	{
  		$adminlvl;

  		if($sData['helper_level'] == 1)
  		{
  			$adminlvl = "Helper";
  			break;
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
	<div class="ui horizontal section divider">
		PLAYER INFORMATION
		</div>
        <div class="ui padded grid">
        <div class="ui sixteen column grid">
        	</div>
        <div class="column">
        <?php
        	$playerskin = $sData['skin_id'];

        	if($sData['job_id'] != 0 || $sData['duty'] != 0)
        		$playerskin = $sJob['skin_id2'];

        	echo '<img style="width: 75px;" src="assets/skin/heads/Skin_'.$playerskin.'.png" class="ui small centered image">';
        ?>

            <div role="list" class="ui list">
                <div role="listitem" class="item">
                    <div class="header">Status</div>
                    <div class="description"><?php 
                    if($sData['isonline'] == 1)
                    {
                        echo 'Online';
                    }
                    else
                    {
                        echo "Offline";
                    } ?></div>
                </div>

                <div role="listitem" class="item">
                    <div class="header">Level</div>
                    <div class="description"><?php echo $sData['level']; ?></div>
                </div>

                <div role="listitem" class="item">
                    <div class="header">Total Playtime</div>
                	<div class="description"><?php echo $sData['hours_online'];  ?></div>
                </div>

                <div role="listitem" class="item">
                    <div class="header">Last online</div>
                    <div class="description"><?php echo $sData['last_login']; ?></div>
            	</div>
        </div>
    </div>
    <div class="column">
        <div role="list" class="ui list">

            <div role="listitem" class="item">
                <div class="header">Cash</div>
                <div class="description"> <?php echo '$'.number_format($sData['playerMoney']); ?></div>
            </div>

            <div role="listitem" class="item">
                <div class="header">Bank Money</div>
                <div class="description"> <?php echo '$'.number_format($sData['playerBank']); ?></div>
            </div>

	        <div role="listitem" class="item">
	            <div class="header">Passport</div>
	            <div class="description">Yes</div>
	        </div>

	        <div role="listitem" class="item">
	            <div class="header">Drivers license</div>
	   			<div class="description"><?php echo ($sData['playerLicense']) ? ("Yes") : ("No") ?></div>
	        </div>

    </div>
</div>
</div>

	<div class="ui horizontal section divider">
		PLAYER GROUPS
		</div>
<?php
$query = $con->prepare("SELECT g.groupId, g.groupName, g.groupType, g.groupTag FROM group_member m INNER JOIN groups g ON (g.groupId = m.groupId) WHERE m.playerId = {$sData['playerId']} AND m.rankLevel != 0;");
$query->execute();

?>

<table class="ui table">
    <thead class="">
        <tr class="">
            <th class="">Type</th>
            <th class="">Name</th>
            <th class="">Rank</th>
        </tr>
    </thead>
    <tbody class="">


  <?php
  if($query -> rowCount() == 0)
  {
    echo "<center><h4><strong>This player has not joined any groups yet.</strong></h4></center>";
  }

  while($row = $query -> fetch())
  {
      $groupId = $row['groupId'];
      $grouprankquery = $con->prepare(
            "SELECT r.rankLevel AS level, r.rankTitle AS title 
            FROM group_member m 
            INNER JOIN group_ranks r ON (r.rankLevel = m.rankLevel AND r.groupId = m.groupId)
            WHERE m.playerId = {$sData['playerId']} AND m.groupId = $groupId");
      $grouprankquery->execute();
      $getGroupRank = $grouprankquery->fetch();

        switch($row['groupType']) 
        {
            case 1:
                $a = '<div class="ui green tiny basic horizontal label">Official</div>';
                break;
            case 2:
                $a = '<div class="ui blue tiny basic horizontal label">Government</div>';
                break;
            case 3:
                $a = '<div class="ui grey tiny basic horizontal label">Business</div>';
                break;
            case 4:
                $a = '<div class="ui grey tiny basic horizontal label">Criminal</div>';
                break;
        }

    echo '<tr class="">
            <td class="one wide">
                '.$a.'
            </td>
            <td class="five wide">
                <h4 class="ui header">
                    <div class="content"><a href="group.php?groupid='.$row['groupId'].'">'.$row['groupName'].'</a>
                        <div class="sub header">'.$row['groupTag'].'</div>
                    </div>
                </h4>
            </td>
            <td class="">'.$getGroupRank['title'].'</td>
        </tr>';
	} 
  ?>
    </tbody>
</table>

<?php

if($_SESSION['playeradmin'] > 1) 
{
    $queryp = $con->prepare("SELECT r.punishmentType, r.punishmentReason, r.punisherId FROM player_punishment r INNER JOIN player p ON (r.playerId = p.playerId) WHERE p.playerId = {$sData['playerId']} ORDER BY r.punishmentTime;");
    $queryp->execute();
	
    $queryn = $con->prepare("SELECT r.playerId, r.noterId, r.noteText, r.noteTime, FROM player_notes r INNER JOIN player p ON (r.playerId = p.playerId) WHERE p.playerId = {$sData['playerId']} ORDER BY r.punishmentTime;");
    $queryn->execute();	
	
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
			<th class="">Admin</th>
		  </tr>
		</thead>
		<tbody>';
		while($row = $queryp -> fetch())
		{
			$adminid = $row['punisherId'];
			echo '<tr>
			<td>';
				switch($row['punishmentType']) 
				{
					case 1:
						echo '<a class="item">
						<div class="ui yellow horizontal label">Ticket</div>
						</a>';
						break;
					case 2:
						echo '<a class="item">
						<div class="ui yellow horizontal label">Warning</div>
						</a>';      
						break;
					case 3:
						echo '<a class="item">
						<div class="ui yellow horizontal label">Kick</div>
						</a>';      
						break;
					case 4:
						echo '<a class="item">
						<div class="ui orange horizontal label">Temp Ban</div>
						</a>';  
						break;
					case 5:
						echo '<a class="item">
						<div class="ui red horizontal label">Full Ban</div>
						</a>';    
						break;
					case 6:
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
			<td>'. $row['punishmentReason'].'</td>
			<td>';
			$adminname = $con->prepare("SELECT playerName FROM player WHERE playerId = $adminid");
			$adminname->execute();
			$adminName = $adminname->fetch();
			echo '<a href="player.php?searchuser='.$adminName['playerName'].'" >'.$adminName['playerName']; echo `</td>
			</tr>`;
		}

		echo '</tbody>
		<tfoot>
		</tfoot>
		</table>
		</div>';
	}
      
        if($queryn -> rowCount() == 0)
        {
			echo '<div class="ui negative message">
			<div class="header">No player notes found</div>
			</div>';
        }
		else
		{
			echo '<div class="four wide column">
			<table class="ui table">
			<thead class="">
			  <tr>
				<th class="">Date</th>
				<th class="">Note</th>
				<th class="">Admin</th>
			  </tr>
			</thead>
			<tbody>';

			while($row = $queryn -> fetch())
			{
				$adminid = $row['noterId'];
				echo '<tr>
					<td>'. $row['noteTime'] .'</td>
					<td>'. $row['noteText'].'</td>
					<td>';
				$adminname = $con->prepare("SELECT playerName FROM player WHERE playerId = $adminid");
				$adminname->execute();
				$adminName = $adminname->fetch();
				echo '<a href="player.php?searchuser='.$adminName['playerName'].'" >'.$adminName['playerName']; echo `</td>
				</tr>`;
			}
			echo '</tbody>
			<tfoot>
			</tfoot>
		</table>
		</div>';
	}
}

	include 'includes/footer.php'; 
?>