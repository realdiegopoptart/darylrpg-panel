<head>
    <meta charset="utf-8" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no"
    />
    <meta
      name="description"
      content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI."
    />
    <meta name="author" content="PPType" />
    <meta name="theme-color" content="#ffffff" />
    <title>Axiania RPG - Panel</title>
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
      type="text/css"
    />

    <style type="text/css">
      body {
        padding-top: 56px;
        -webkit-font-smoothing: antialiased;
        -moz-font-smoothing: grayscale;
      }

      .ui.grid {
        margin-top: 0 !important;
      }

      .ui.vertical.menu {
        width: auto;
      }

      .ui.right.sidebar.vertical.menu {
        width: 15rem;
      }

      .three.wide.column > .ui.vertical.menu > a.item.active,
      .ui.right.sidebar.vertical.menu > a.item.active,
      .three.wide.column > .ui.vertical.menu > a.item.active:hover,
      .ui.right.sidebar.vertical.menu > a.item.active:hover {
        background-color: #337ab7;
        color: white;
        border: none !important;
      }

      .three.wide.column > .ui.vertical.menu > a.item:hover,
      .ui.right.sidebar.vertical.menu > a.item:hover {
        background-color: #f5f5f5;
      }

      .ui.fixed.borderless.menu {
        padding: 0;
        flex-wrap: wrap;
      }

      .ui.fixed.borderless.menu .row > a.header.item {
        font-size: 1.2rem;
      }

      .ui.message {
        background-color: rgba(238, 238, 238);
        box-shadow: none;
        padding: 5rem 4rem;
      }

      .ui.message h1.ui.header {
        font-size: 4.5rem;
      }

      .ui.message p.lead {
        font-size: 1.3rem;
        color: #333333;
        line-height: 1.4;
        font-weight: 300;
      }

      @media only screen and (max-width: 767px) {
        .ui.message h1.ui.header {
          font-size: 2rem;
        }
      }

      button.ui.top.right.attached.button {
        position: absolute;
        top: 0;
        right: 0;
        border-bottom-right-radius: 0;
        padding-right: 0.75rem;
      }

      .pushable {
        height: unset;
        overflow-x: visible;
      }

      .ui.right.sidebar {
        height: auto !important;
        margin-top: 1rem !important;
        padding-left: 0;
        padding-right: 0;
      }

      footer {
        padding: 24px 0;
      }
    </style>
  </head>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

  <body id="root">
    <div class="ui grid">
      <div class="ui top fixed borderless huge inverted menu" style="padding: 8px">
        <div class="ui container">
          <p class="header item">Axiania RPG</p>
          <a href="index.php" class="item">Home</a> 
          <a href="assets.php" class="item">Assets</a>
          <?php
          echo '<a href="player.php?searchuser='.$_SESSION['playername'].'"class="item">Profile</a>';
          ?>
        </div>

 		<form method="GET" action="player.php" style="height: 42px; padding-top: 10px;" class="ui icon mini input">
    		<input type="text" placeholder="Search players" name="searchuser" id="searchuser">
    	</form>
        	
        <a href="logout.php" class="item">Logout</a>
      </div>