<?php 
include 'includes/config.php'; 
include 'includes/header.php';

checkForLogin();

if(isset($_GET['id']))
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../pages/index.php">';    
	exit;	
}

$sesuID = $_SESSION['uID'];
?>

      <div class="ui container">
        <div class="ui padded grid">
          <div class="twelve wide column">
            <div class="ui message">
              <h1 class="ui header"><?php 
              echo str_replace("_"," ",$_SESSION['playername']);?></h1>
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui grid">
              <div class="three column row">
                <div class="column">
                <div role="list" class="ui divided very relaxed list">
                <a role="listitem" class="item" href="samp://51.79.204.126:7777" target="_blank">
                      <i aria-hidden="true" class="game icon"></i>
                      <div class="content">
                          <div class="header">SA:MP</div>
                          <div class="description">Click on me to connect!</div>
                      </div>
                  </a>
                  <a role="listitem" class="item" href="https://axiania.com" target="_blank">
                      <i aria-hidden="true" class="browser icon"></i>
                      <div class="content">
                          <div class="header">Forums</div>
                          <div class="description">Ban Appeals, Suggestions, and more!</div>
                      </div>
                  </a>
                  <a role="listitem" class="item" href="https://discord.gg/FuerHArrXF" target="_blank">
                      <i aria-hidden="true" class="discord outline icon"></i>
                      <div class="content">
                          <div class="header">Discord</div>
                          <div class="description">Join the discord server.</div>
                      </div>
                  </a>
              </div>

                </div>
              </div>
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui divider"></div>
            <footer>Axiania RPG</footer>
          </div>
          <div class="four wide column">
            <p>Online players:</p>
            <div class="ui vertical menu">
              <?php
              $isonlinequery = $con->prepare("SELECT user_name, admin_lvl, helper_level, acforced FROM users WHERE isonline = 1");
              $isonlinequery->execute();

              if($isonlinequery -> rowCount() == 0)
              {
                echo '<a class="item">No players are online</a>';
              }
              else
              {
                while($row = $isonlinequery -> fetch())
                {
					$stafftag;

					if($row['helper_level'] == 1)
					{
						$stafftag = '<div class="ui green tiny basic horizontal label">Helper</div>';
					}
					else
					{
						switch($row['admin_lvl']) 
						{
							case 1:
								$stafftag = '<div class="ui green tiny basic horizontal label">Moderator</div>';
								break;
							case 2:
								$stafftag = '<div class="ui green tiny basic horizontal label">Junior Admin</div>'; 
								break;
							case 3:
								$stafftag = '<div class="ui red tiny basic horizontal label">Senior Admin</div>';
								break;
							case 4:
								$stafftag = '<div class="ui orange tiny basic horizontal label">Manager</div>';
								break;
							case 5:
								$stafftag = '<div class="ui red tiny basic horizontal label">Server Leader</div>';
								break;
							case 6:
								$stafftag = '<div class="ui red tiny basic horizontal label">Director</div>';
								break;
							case 7:
								$stafftag = '<div class="ui red tiny basic horizontal label">Owner</div>';
								break;
							default:
								$stafftag = "";
								break;
						};
					}				    
                  $playerusername = $row['user_name'];

                  if($row['acforced'])
                  {
                    $playerusername = '<font color="#0dda1d">[+]</font> ' . $row['user_name'];
                  }
                  
                  echo '<a href="player.php?searchuser='.$row['user_name'].'" class="item">'.$playerusername . $stafftag.'</a>';
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
        
<?php 
    include_once "includes/footer.php";
?>