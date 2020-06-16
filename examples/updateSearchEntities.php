<?php 

require_once __DIR__ . '/bootstrap.php';

$response = $client->updateSearchEntities('1592312982-EZMyGbAr', [
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