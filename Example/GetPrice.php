<?php
require_once '../vendor/autoload.php';

if (!function_exists('curl_reset'))
{
    function curl_reset(&$ch)
    {
        $ch = curl_init();
    }
}

$apiKey = 'vbm1lxide8rkibzos16232b816eea0oq7qbqfxry';
$client = new \Bdok\PostGateway\Client($apiKey);

$res = $client->getPrice([
    'weight' => 100,
    'price' => 1000,
    'state' => 1, // Tehran
    'city' => 1, // Tehran
    'tip' => 0, // Sefareshi
    'cod' => 0, // With COD
]);

var_dump($res);