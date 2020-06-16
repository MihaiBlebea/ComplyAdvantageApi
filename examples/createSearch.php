<?php 

require_once __DIR__ . '/bootstrap.php';

use Chip\ComplyAdvantageApi\Requests\CreateSearchRequest;

$request = new CreateSearchRequest([
    "search_term" => [
        'first_name' => 'Mihai',
        'last_name' => 'Blebea'
    ],
    "fuzziness" => 0.6,
    "filters" => [
        "types"=> ["sanction", "warning"]
    ],
    "share_url" => 1
]);

$response = $client->createSearch($request);

var_dump($response);