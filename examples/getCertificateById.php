<?php 

require_once __DIR__ . '/bootstrap.php';

$response = $client->getCertificateById('1592312982-EZMyGbAr');

var_dump($response);