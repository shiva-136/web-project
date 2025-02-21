<?php

require 'config.php';

$error_message = '';


if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = rand(1000, 9999);
}


if (isset($_POST["submit"])) {
    $usernameemail = $_POST["usernameemail"];
    $password = $_POST["password"];
    $user_captcha = $_POST['captcha'];

    if ($user_captcha != $_SESSION['captcha']) {
        $error_message = 'CAPTCHA Verification Failed!';
    } else {
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$usernameemail' OR email='$usernameemail'");
        
        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row["password"])) { 
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                header("Location: index.php");
                exit();
            } else {
                $error_message = 'Invalid password. Please try again.';
            }
        } else {
            $error_message = 'User not registered. Please try again.';
        }
    }
}


if (isset($_POST["id_token"])) {
    $client_id = "42793519428-kr82fcaadj1f6o6osljj0bgmujp3oolp.apps.googleusercontent.com";
    $id_token = $_POST["id_token"];

 
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
    $response = file_get_contents($url);
    $user_info = json_decode($response, true);

    if (isset($user_info['email'])) {
        $email = $user_info['email'];
        $name = $user_info['name'];

   
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
        } else {
            
            mysqli_query($conn, "INSERT INTO tb_user (username, email) VALUES ('$name', '$email')");
            $_SESSION["login"] = true;
            $_SESSION["id"] = mysqli_insert_id($conn);
        }
        echo json_encode(["success" => true]);
        exit();
    }
    echo json_encode(["success" => false]);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <div class="container">
            <div class="main">
                <div class="content">
                    <h2>Log In</h2>
                    
                  
                    <form method="post">
                        <?php if (!empty($error_message)) : ?>
                            <div class="error-message"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <input type="text" name="usernameemail" placeholder="Username or Email" required><br>
                        <input type="password" name="password" placeholder="Password" required><br>
                        <p>CAPTCHA: <strong><?php echo $_SESSION['captcha']; ?></strong></p>
                        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required><br>
                        <button class="btn" type="submit" name="submit">Login</button>
                    </form>
                    
                    <br>
                    <p class="account">Don't have an account? <a href="registration.php">Register</a></p>
                    
                   
                    <div id="g_id_onload"
                         data-client_id="42793519428-kr82fcaadj1f6o6osljj0bgmujp3oolp.apps.googleusercontent.com"
                         data-context="signin"
                         data-ux_mode="popup"
                         data-callback="handleCredentialResponse"
                         data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin" data-type="standard"></div>

                    <script>
                        function handleCredentialResponse(response) {
                            fetch("login.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                body: "id_token=" + response.credential
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.href = "index.php";
                                } else {
                                    alert("Google login failed!");
                                }
                            });
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
