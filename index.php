<?php
require 'config.php'; 

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT name FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="view.css">
    
</head>
<body>
    <div class="login-form">
        <h1>Welcome <?php echo $row["name"]; ?></h1>
        <div class="content">
            <button  class="btn" type="submit" name="submit"><a href="view.php">View</a></button>
            <button  class="btn" type="submit" name="submit"><a href="logout.php">Logout</a></button>
        </div>
    </div>
  
</body>
</html>
