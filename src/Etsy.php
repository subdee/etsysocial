<?php
namespace subdee\etsysocial;

class Etsy
{
    public function getRandomEtsyListing()
    {
        if ($listings = $this->getListings(Config::ETSY_SHOP)) {
            $getRandom = function ($listings) use (&$getRandom) {
                $rand = rand(0, $listings->count);
                return isset($listings->results[$rand]) ? $listings->results[$rand] : $getRandom($listings);
            };
            return $getRandom($listings);
        }
        return false;
    }

    public function getListings($shop)
    {
        $ch = curl_init('https://openapi.etsy.com/v2/shops/' . $shop . '/listings/active?api_key=' . Config::ETSY_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);
    }
}