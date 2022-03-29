<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'm152';
$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, username FROM users WHERE user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($password, $username);
$stmt->fetch();
$stmt->close();

if (isset($_GET['reset'])) {
    $cp = $_GET['currentpassword'];
    $np = $_GET['newpassword'];
    if ($cp == $password) {
        $stmt = $con->prepare('UPDATE users SET password=? WHERE user_id=?');
        $stmt->bind_param('si', $np, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
        header('Location: home.php');
    } else {
        echo '<style type="text/css">
			body .wrongcp {
					display: block;
			}
			</style>';
    }
    unset($_GET['reset']);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Travel</h1>
				<a href="home.php"><img class="navtopicon" src="icons/home.png" />Home</a>
				<a href="logout.php"><img class="navtopicon" src="icons/logout.png" />Logout</a>
			</div>  
		</nav>
		<div class="content">
			<div>
				<table>
					<tr>
						<td>Username:</td>
						<td><?= $username ?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?= $password ?></td>
					</tr>
				</table>
        <div class="resetpassword">
        <form action="" method="get">
					<p class="wrongcp">The current Password is not correct</p>
          <label for="currentpassword">Current Password</label>
          <input type="password" id="currentpassword" name="currentpassword" required><br>
          <label for="newpassword">New Password</label>
          <input type="password" id="newpassword" name="newpassword" required> <br>
          <input name="reset" type="submit" value="Save" />
        </form>
      </div>
			</div>
		</div>
	</body>
</html>