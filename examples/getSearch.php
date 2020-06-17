<?php 

require_once __DIR__ . '/bootstrap.php';

use Chip\ComplyAdvantageApi\Requests\GetSearchRequest;
use Chip\ComplyAdvantageApi\Filters\CreatedTimeFilter;

$request = new GetSearchRequest();

$createdFilter = new CreatedTimeFilter([
    'from' => new DateTime('2020-04-01')
]);

$request->setFilters($createdFilter);

$response = $client->getSearch($request);

var_dump($response);