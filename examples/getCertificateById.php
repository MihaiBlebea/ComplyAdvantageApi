<?php 

require_once __DIR__ . '/bootstrap.php';

$response = $client->getCertificateById('1592479788-dq2eR46T');

var_dump($response);