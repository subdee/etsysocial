<?php
namespace subdee\etsysocial;

use Codebird\Codebird;

class Twitter {
    /**
     * @var Codebird
     */
    public $cb;

    public function __construct()
    {
        Codebird::setConsumerKey(Config::TWITTER_KEY, Config::TWITTER_SECRET);
        $cb = Codebird::getInstance();
        $cb->setToken(Config::TWITTER_TOKEN, Config::TWITTER_TOKEN_SECRET);
        $this->cb = $cb;
    }

    public function tweet($message)
    {
        $this->cb->statuses_update('status=' . $message);
    }

    public function requestOauthToken()
    {
        $reply = $this->cb->oauth_requestToken(array(
                'oauth_callback' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
            ));

        // store the token
        $this->cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
        $_SESSION['oauth_verify'] = true;

        // redirect to auth website
        return $this->cb->oauth_authorize();
    }

    public function verifyToken()
    {
        // verify the token
        $this->cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        unset($_SESSION['oauth_verify']);

        // get the access token
        $reply = $this->cb->oauth_accessToken(array(
                'oauth_verifier' => $_GET['oauth_verifier']
            ));

        // store the token (which is different from the request token!)
        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;

        return true;
    }
}