<?php
include 'includes/config.php';

if(!isset($_SESSION['playername']))
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';   
	exit;
}

if(isset($_POST['admincode']))
{
	$admincode = $_POST['admincode'];

	$aquery = $con->prepare("SELECT `admin_lvl`, `user_name`, `user_id` FROM `users` WHERE `user_name` = ? and `password` = ?");

	if($aquery->rowCount() > 0)
	{
		$data = $aquery->fetch();

		if($data['admincode'] == $_POST['admincode'])
			$_SESSION['verifiedadmin'] = 1;
		else
			$err = 'Unable to verify your admin code (Error code: 2)';
			
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';   
		exit;
	}
	else
	{
		$err = 'Unable to verify your admin code (Error code: 1)';
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no"
    />
    <meta
      name="description"
      content="Axiania RPG"
    />
    <meta name="theme-color" content="#ffffff" />

    <title>Axiania RPG</title>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
      type="text/css"
    />
    <style type="text/css">
      body {
        background-color: #eee;
        -webkit-font-smoothing: antialiased;
        -moz-font-smoothing: grayscale;
      }

      .ui.container {
        margin-top: 6rem;
        max-width: 22rem !important;
      }

      .ui.large.form > .field:first-child {
        margin-bottom: 0;
      }
    </style>
  </head>

  <body id="root">
    <div class="ui center aligned grid">
      <div class="ui container">
        <h1 class="ui huge header">Axiania RPG Panel</h1>
        <form class="ui large form" action="login.php" method="POST">
          <div class="field">
            <div class="ui input">
              <input placeholder="Admin Code" type="password" id="ppass" name="ppass" />
            </div>
            	<?php if(isset($err)) 
					echo '<center><b style="color: red;">'.$err.'</b></center>'; 
				?>
          </div>
          <p>You must verify with your admin code.</p>
          <button class="ui fluid large primary button" type="submit">
            Verify
          </button>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script>
      $(document).ready(function() {
        $(".ui.checkbox").checkbox();
        $(".ui.form").form({
          fields: {
            admincode: {
              identifier: "admincode",
              rules: [
                {
                  type: "length[3]",
                  prompt: "Your admin code is atleast 3 numbers"
                }
              ]
            }
          },
          inline: true,
          on: "blur"
        });
      });
    </script>
  </body>
</html>