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
                  <a role="listitem" class="item" href="https://a-rpg.com" target="_blank">
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
                          <div class="description">Join the discord server</div>
                      </div>
                  </a>
              </div>

                </div>
              </div>
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui divider"></div>
            <footer>Asiania RPG</footer>
          </div>
          <div class="four wide column">
            <p>Online players:</p>
            <div class="ui vertical menu">
              <?php
              $isonlinequery = $con->prepare("SELECT user_name FROM users WHERE isonline = 1");
              $isonlinequery->execute();
              if($isonlinequery -> rowCount() == 0)
              {
                echo '<a class="item">No players are online</a>';
              }
              else
              {
                while($row = $isonlinequery -> fetch())
                {
                  echo '<a class="item">'.$row['user_name'].'<div class="ui red tiny basic horizontal label">Owner</div></a>';
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