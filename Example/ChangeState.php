<?php

require_once '../vendor/autoload.php';

$apiKey = 'YOUR_API_KEY';
$client = new \Bdok\PostGateway\Client($apiKey);

$tracking_number = 12345678901234567890;
$state = 1; // 1 => Moalagh dar foroshgah, 2 => amade ghabool

// Returns boolean, true on success process
$res = $client->changeState($tracking_number, $state);

var_dump($res);
