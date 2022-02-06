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
      content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI."
    />
    <meta name="keywords" content="Semantic-UI, Theme, Design, Template" />
    <meta name="author" content="PPType" />
    <meta name="theme-color" content="#ffffff" />
    <title>Signin Template for Semantic-UI</title>
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
        <h1 class="ui huge header">Asiania RPG Panel</h1>
        <form class="ui large form">
          <div class="field">
            <div class="ui input">
              <input name="username" placeholder="Username" type="text" />
            </div>
          </div>
          <div class="field">
            <div class="ui input">
              <input name="password" placeholder="Password" type="password" />
            </div>
          </div>
          <button class="ui fluid large primary button" type="submit">
            Sign in
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
            username: {
              identifier: "username",
              rules: [
                {
                  type: "empty",
                  prompt: "Please enter your in-game username"
                }
              ]
            },
            password: {
              identifier: "password",
              rules: [
                {
                  type: "empty",
                  prompt: "Please enter your password"
                },
                {
                  type: "length[6]",
                  prompt: "Your password must be at least 6 characters"
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