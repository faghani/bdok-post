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


$tracking_number = 12345678901234567890;
$state = 1;
$res = $client->changeState($tracking_number, $state);

var_dump($res);