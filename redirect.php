<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("7084749231-u9qop0aq5cquj31vhesmbe1u3q4tkq87.apps.googleusercontent.com
");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/reglog/redirect.php");

if ( ! isset($_GET["code"])) {

    exit("Login failed");

}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);