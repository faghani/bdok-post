<?php
require_once '../vendor/autoload.php';

$apiKey = 'YOUR_API_KEY';
$client = new \Bdok\PostGateway\Client($apiKey);

// Your order array
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

// Submit order
$res = $client->newOrder($fakeOrder);

// An array, $res[1] => Post tracking number
var_dump($res);