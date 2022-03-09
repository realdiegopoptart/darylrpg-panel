<?php 
include 'includes/config.php'; 
include 'includes/header.php';
checkForLogin();

if(isset($_GET['id']))
{
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../pages/index.php">';    
    exit;   
}

if(isset($_GET['groupid']))
{
    $getGroupId = $_GET['groupid'];

    $query = $con->prepare("SELECT * from groups g INNER JOIN group_ranks r ON (g.group_id = r.group_id) WHERE g.group_id = $getGroupId");
    $query->execute();
    $gData = $query->fetch();
}

$bquery = $con->prepare("SELECT * FROM group_members WHERE groupid = $getGroupId");
$bquery->execute();

$cquery = $con->prepare("SELECT veh_id FROM vehicles WHERE v_type = 2 AND v_group = $getGroupId");
$cquery->execute();
?>

    <div class="ui container">
      <div class="ui padded grid">
        <div class="wide column">


<div class="ui segment">
  <div class="ui header">
    <?php echo $gData['name']; ?>
    <div class="ui grey tiny basic horizontal label"><?php echo 'id: '.$gData['group_id']; ?></div>

    <?php
        switch($gData['type']) 
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
        echo $a; ?>
  </div>

    <div class="ui horizontal section divider">
        GROUP INFORMATION
        </div>

    <div class="ui segment">
        <div class="ui tiny four statistics">
            <div class="ui statistic">
                <div class="value"><i aria-hidden="true" class="user icon"></i> <?php echo intval($bquery->rowCount()) ?></div>
                <div class="label"><small>Group Members</small></div>
            </div>
            <div class="ui statistic">
                <div class="value"><i aria-hidden="true" class="tag icon"></i> <?php echo $gData['prefix']; ?></div>
                <div class="label"><small>Group Tag</small></div>
            </div>
            <div class="ui statistic">
                <div class="value"><i aria-hidden="true" class="car icon"></i> <?php echo intval($cquery->rowCount()) ?></div>
                <div class="label"><small>Group Vehicles</small></div>
            </div>
            <div class="ui statistic">
                <div class="value"><i aria-hidden="true" class="crosshairs icon"></i> <?php echo $gData['points']; ?></div>
                <div class="label"><small>Group Points</small></div>
            </div>
        </div>
    </div>

    <div class="ui horizontal section divider">
        GROUP MEMBERS
        </div>

<table class="ui table">
    <thead class="">
        <tr class="">
            <th class="">Player</th>
            <th class="">Rank</th>
        </tr>
    </thead>
    <tbody class="">


<?php

while($row = $bquery -> fetch())
{

    $playername = $con->prepare("SELECT user_name FROM users WHERE user_id = {$row['user_id']}");
    $playername->execute();
    $getplayername = $playername->fetch();

    $rankname = $con->prepare("SELECT rank_name FROM group_ranks WHERE rank_level = {$row['user_rank']} AND group_id = $getGroupId");
    $rankname->execute();
    $getrankname = $rankname->fetch();

  echo '<td class="five wide">
              <h4 class="ui header">
                  <div class="content"><a href="player.php?searchuser='.$getplayername['user_name'].'">'.$getplayername['user_name'].'</a>
                  </div>
              </h4>
          </td>
          <td class="">'.$getrankname['rank_name'].'</td>
      </tr>';
} 
?>
  </tbody>
</table>

<div class="panel-footer">
    <?php include 'includes/footer.php'; ?>
</div>
