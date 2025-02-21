<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("7084749231-u9qop0aq5cquj31vhesmbe1u3q4tkq87.apps.googleusercontent.com
");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/reglog/redirect.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Login Example</title>
</head>
<body>

    <a href="<?= $url ?>">Sign in with Google</a>

</body>
</html>