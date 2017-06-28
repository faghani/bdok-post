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

$fakeOrder = [
    'customerPhone' => '09125076324',
    'reference' => '123456',
    'state' => 1,
    'city' => 1,
    'names' => 'عروسک خرس مهربون',
    'weight' => 250,
    'price' => 15000,
    'shipment' => 0, // Sefareshi
    'payment' => 0, // COD
    'customerName' => 'علیرضا فغانی',
    'address' => 'پاسداران گلستان اول در قهوه ای پلاک 0',
    'postalCode' => 1234567890,
    'customerEmail' => 'faghani.a@gmail.com',
];

$res = $client->newOrder($fakeOrder);

var_dump($res);