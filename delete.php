<?php
require 'config.php';


if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];


if (isset($_POST["delete"])) {
    $query = "DELETE FROM tb_user WHERE id='$user_id'";
    if (mysqli_query($conn, $query)) {
        session_destroy();
        header("Location: registration.php"); 
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete account');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="delete.css">
</head>
<body>
    <h2>Are you sure you want to delete your account?</h2>
    <form action="" method="post">
        <button type="submit" name="delete" >Delete Account</button>
    </form>
    <br>
    <a href="view.php">Back to Profile</a>
</body>
</html>

