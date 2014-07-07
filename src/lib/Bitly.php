<?php
namespace subdee\etsysocial\lib;

use Hpatoio\Bitly\Client;

class Bitly {
    public function shortenUrl($url)
    {
        $bitly = new Client(Config::BITLY_KEY);
        $res = $bitly->shorten(['longUrl' => $url]);
        if (isset($res['url'])) {
            return $res['url'];
        }
        return $url;
    }
}