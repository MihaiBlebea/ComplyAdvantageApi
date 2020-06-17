<?php 

require_once __DIR__ . '/bootstrap.php';

$response = $client->getSearchById('1592391215-mGndPRqB');

var_dump($response);