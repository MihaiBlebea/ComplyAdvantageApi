<?php 

require_once __DIR__ . '/bootstrap.php';

$response = $client->createSearch([
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

var_dump($response);