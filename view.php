<?php
require 'config.php';



if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];


$result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id='$user_id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "User not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
<div class="view">
<div class="container">
<div class="main">
<div class="content">
    <h2>View Profile</h2>
    <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
    <p><strong>Username:</strong> <?php echo $row['username']; ?></p>
    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>

    <button type="submit" name="submit"><a href="edit.php">Edit Profile</a></button>
    <button type="submit" name="submit"><a href="delete.php">Delete Account</a></button>
    <br>
    <a href="logout.php">Logout</a>
    </div>
    </div>
    </div>
    </div>
</body>
</html>
