<?php
require_once '../vendor/autoload.php';

$apiKey = 'YOUR_API_KEY';
$client = new \Bdok\PostGateway\Client($apiKey);

// Get price
$res = $client->getPrice([
    'weight' => 100, // Product weight in gr
    'price' => 1000, // Product price
    'state' => 1, // Id state
    'city' => 1, // Id city
    'tip' => 0, // 0 => Sefareshi, 1 => pishtaz
    'cod' => 0, // 0 => COD, 1=> Online
]);

// Returns array of price
var_dump($res);