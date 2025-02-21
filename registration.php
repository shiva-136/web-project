<?php
require 'config.php';

$password_error = '';  
$username_error = '';
$email_error = '';
$confirm_password_error = '';  

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{7,}$/', $password)) {
        $password_error = 'Password must have at least 1 uppercase, 1 lowercase, 1 digit, 1 special character and be at least 7 characters long.';
    } elseif ($password !== $confirmpassword) {
        $confirm_password_error = 'Passwords not matched';  
    } else {
        
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username) {
                $username_error = 'Username is already taken.';
            }
            if ($row['email'] === $email) {
                $email_error = 'Email is already registered.';
            }
        } else {
            
            $query = "INSERT INTO tb_user (name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registration successful');</script>";
                header("Location: login.php");
                exit();
            } else {
                echo "<script>alert('Error: Unable to register');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Register</h2>
        <form action="" method="post">
            <input type="text" name="name" id="name" placeholder="Name" required><br>
            
            <?php if ($username_error): ?>
                <div class="error-message"><?php echo $username_error; ?></div>
            <?php endif; ?>
            <input type="text" name="username" id="username" placeholder="Username" required><br>

            <?php if ($email_error): ?>
                <div class="error-message"><?php echo $email_error; ?></div>
            <?php endif; ?>
            <input type="email" name="email" id="email" placeholder="Email" required><br>

            <?php if ($password_error): ?>
                <div class="error-message"><?php echo $password_error; ?></div>
            <?php endif; ?>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <h7>*Password must have at least 1 uppercase,<br>
                *1 lowercase, <br>
                *1 digit, <br>
                *1 special character and be at least 7 characters long</h7><br>
            
            <?php if ($confirm_password_error): ?>
                <div class="error-message"><?php echo $confirm_password_error; ?></div>
            <?php endif; ?><br>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required><br>

            <button type="submit" name="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
