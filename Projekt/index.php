<!DOCTYPE html>
<html>
  <head>
  <?php if (isset($_POST['submit'])) {
      require 'authenticate.php';
  } ?>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="login">
      <h1>Login</h1>
      <form method="post">
        <label for="username">
          <img class="logicon" src="icons/uname.png" />
        </label>
        <input
          type="text"
          name="username"
          placeholder="Username"
          id="username"
          required
        />
        <label for="password">
          <img class="logicon" src="icons/passwd.png" />
        </label>
        <input
          type="password"
          name="password"
          placeholder="Password"
          id="password"
          required
        />
        <p class="wronglogin">Incorrect username and/or password!</p>
        <input name="submit" type="submit" value="Login" />
      </form>
    </div>
  </body>
</html>
