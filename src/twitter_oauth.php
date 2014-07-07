<?php
require_once '../EtsySocial.php';

session_start();
$_SERVER['HTTP_HOST'] = '127.0.0.1';
$_SERVER['REQUEST_URI'] = '/etsysocial/src/twitter_oauth.php';

$twitter = new \subdee\etsysocial\lib\Twitter();
if (! isset($_SESSION['oauth_token'])) {
    $authUrl = $twitter->requestOauthToken();
    header('Location: ' . $authUrl);
    die();

} elseif (isset($_GET['oauth_verifier']) && isset($_SESSION['oauth_verify'])) {
    $twitter->verifyToken();
    header('Location: ' . basename(__FILE__));
    die();
}

echo $_SESSION['oauth_token'] . '<br>' . $_SESSION['oauth_token_secret'];