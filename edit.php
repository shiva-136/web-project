<?php
require 'config.php';


if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];


if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

   
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE (username='$username' OR email='$email') AND id != '$user_id'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already taken');</script>";
    } elseif ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
       
        if ($password) {
            
            $query = "UPDATE tb_user SET name='$name', username='$username', email='$email', password='$password' WHERE id='$user_id'";
        } else {
            
            $query = "UPDATE tb_user SET name='$name', username='$username', email='$email' WHERE id='$user_id'";
        }

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Profile updated successfully');</script>";
        } else {
            echo "<script>alert('Error: Unable to update profile');</script>";
        }
    }
}


$result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id='$user_id'");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    
    <h2>Edit Profile</h2>
    <form action="" method="post">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Name" required><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Username" required><br>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="New Password"><br>
        <input type="password" name="confirmpassword" placeholder="Confirm New Password"><br>
        <button type="submit" name="submit">Update Profile</button>
    </form>
    <br>
    <a href="view.php">Back to Profile</a>
</body>
</html>
