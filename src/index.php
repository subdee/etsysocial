<?php
include('bootstrap.php');

/** @var subdee\etsysocial\EtsySocial $etsySocial */
$etsySocial = $container->get(subdee\etsysocial\EtsySocial::class);
$etsySocial->tweetRandomItem();