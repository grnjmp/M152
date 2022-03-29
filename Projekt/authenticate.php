<?php
session_start();

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

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

if (
    $stmt = $con->prepare(
        'SELECT user_id, password FROM users WHERE username = ?'
    )
) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $password);
        $stmt->fetch();

        if ($_POST['password'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['user_id'] = $userid;
            header('Location: home.php');
        } else {
            // Incorrect password
            echo '<style type="text/css">
            body .wronglogin {
                display: block;
            }
            </style>';
        }
    } else {
        // Incorrect username
        echo '<style type="text/css">
        body .wronglogin {
            display: block;
        }
        </style>';
    }
    $stmt->close();
}
?>
