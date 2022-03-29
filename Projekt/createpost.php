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

if (isset($_POST['submitcreate'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileTmpExt = explode('.', $fileName);
    $fileExt = strtolower(end($fileTmpExt));
    $allowed = ['jpg', 'jpeg', 'png'];
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            $fileNewName = uniqid('', true) . '.' . $fileExt;
            $filedes = 'uploads/' . $fileNewName;
            move_uploaded_file($fileTmp, $filedes);
            $description = $_POST['description'];
            $stmt = $con->prepare(
                'INSERT INTO posts (link,description,user_id,postdislike,postlike,license) VALUES (?,?,?,0,0,?)'
            );
            $stmt->bind_param(
                'ssis',
                $filedes,
                $description,
                $_SESSION['user_id'],
                $_POST['license']
            );
            $stmt->execute();
            $stmt->close();
            header('Location:home.php');
        } else {
            echo 'there was an error uploading the file';
        }
    } else {
        echo 'wrong file type! ' . $fileExt;
    }
}
if (isset($_POST['cancel'])) {
    header('Location:home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet" type="text/css">
  <title></title>
</head>
<body>
    <div class="create-body">
  <form action="" method="post" enctype="multipart/form-data" class="new-post">
    <input type="file" name="file">
    <br><br><label for="description">Description</label><br>
    <input type="text" id="description" name="description" required><br><br>
      
  <label for="license">License</label><br>
  <select name="license" id="license">
    <option value="CC0">CC0</option>
    <option value="BY">BY</option>
    <option value="BY-SA">BY-SA</option>
    <option value="BY-NC">BY-NC</option>
    <option value="BY-NC-SA">BY-NC-SA</option>
    <option value="BY-ND">BY-ND</option>
    <option value="BY-NC-ND">BY-NC-ND</option>
  </select>

  <br><br><button type="submit" name="submitcreate">Save</button>
  <button type="submit" name="cancel">Cancel</button>
  </form>
  </div>
</body>
</html>
