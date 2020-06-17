<?php 

require_once __DIR__ . '/bootstrap.php';

use Chip\ComplyAdvantageApi\Requests\CreateSearchRequest;
use Chip\ComplyAdvantageApi\SearchTerm;
use Chip\ComplyAdvantageApi\Filters\FilterFactory;

// $request = new CreateSearchRequest([
//     "search_term" => [
//         'first_name' => 'Mihai',
//         'last_name' => 'Blebea'
//     ],
//     "fuzziness" => 0.6,
//     "filters" => [
//         "types"=> ["sanction", "warning"]
//     ],
//     "share_url" => 1
// ]);

$request = new CreateSearchRequest();

$searchTerm = new SearchTerm();
$searchTerm->setFirstName('Ion');
$searchTerm->setLastName('Iliescu');

$request->setSearchTerm($searchTerm);

$typeFilter = FilterFactory::build('TypeFilter', ['sanction', 'warning']);
$countryFilter = FilterFactory::build('CountryFilter', ['RO']);

$request->shouldShareUrl(true);
$request->setClientRef("CHIP_001");

$request->setFilters($typeFilter, $countryFilter);

// var_dump($request);
// die();


$response = $client->createSearch($request);

var_dump($response);