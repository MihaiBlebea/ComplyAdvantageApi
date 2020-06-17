<?php 

require_once __DIR__ . '/bootstrap.php';


use Chip\ComplyAdvantageApi\Requests\UpdateSearchEntityRequest;

$request = new UpdateSearchEntityRequest();

$request->addEntity('4M5XVH324PPZWLN');
$request->setMatchStatus('true_positive');
$request->setRiskLevel('low');
$request->setWhitelist(true);

$response = $client->updateSearchEntities('1592391215-mGndPRqB', $request);

var_dump($response);