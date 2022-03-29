<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
if (isset($_POST['create'])) {
    header('Location: createpost.php');
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
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Travel</h1>
				<a class="home-create-button" href="createpost.php"><img class="navtopicon" src="icons/create.png" />Create</a>
				<a href="profile.php"><img class="navtopicon" src="icons/profile.png" />Profile</a>
				<a href="logout.php"><img class="navtopicon" src="icons/logout.png" />Logout</a>
			</div>
		</nav>
		<div class="galerie">
			<?php
   $sql = 'SELECT * FROM posts';
   $result = $con->query($sql);
   if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           $link = $row['link'];
           $description = $row['description'];
           echo '<div class="picturebox"><picture><img src=' .
               $link .
               ' class="galeriepicture"></picture>
							 <p class="picdes">' .
               $description .
               '</p>
							 </div>';
       }
   }
   ?>
	</body>
</html>