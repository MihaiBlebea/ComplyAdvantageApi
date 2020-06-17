<?php 

require_once __DIR__ . '/bootstrap.php';

use Chip\ComplyAdvantageApi\Requests\UpdateSearchRequest;

$request = new UpdateSearchRequest();

$request->setMatchStatus('true_positive');
$request->setRiskLevel('high');
$request->setWhitelist(false);

$response = $client->updateSearch('1592389274-EkrIIrvg', $request);

var_dump($response);