<?php
namespace subdee\etsysocial;

class EtsySocial
{
    private $twitter;
    private $bitly;
    private $etsy;

    public function __construct(Twitter $twitter, Bitly $bitly, Etsy $etsy)
    {
        $this->twitter = $twitter;
        $this->bitly = $bitly;
        $this->etsy = $etsy;
        return;
    }

    public function tweetRandomItem()
    {
        if ($listing = $this->etsy->getRandomEtsyListing()) {
            $this->twitter->tweet($listing->title . ' ' . $this->bitly->shortenUrl($listing->url) . '');
        }
    }
}