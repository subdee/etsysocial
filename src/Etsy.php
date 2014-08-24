<?php
namespace subdee\etsysocial;

class Etsy
{
    public function getRandomEtsyListing()
    {
        $db = new EtsyDb();
        if ($listings = $this->getListings(Config::ETSY_SHOP)) {
            $getRandom = function ($listings) use (&$getRandom,$db) {
                $rand = rand(0, $listings->count);
                if (isset($listings->results[$rand]) && $db->isNotMaxListing($rand)) {
                    $db->incrementListing($rand);
                    return $listings->results[$rand];
                }
                return $getRandom($listings);
            };
            return $getRandom($listings);
        }
        return false;
    }

    public function getListings($shop)
    {
        $ch = curl_init('https://openapi.etsy.com/v2/shops/' . $shop . '/listings/active?api_key=' . Config::ETSY_KEY . '&limit=100');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);
    }
}