<?php

namespace Chip\ComplyAdvantageApi;

use Chip\ComplyAdvantageApi\Requests\CreateSearchRequest;
use Chip\ComplyAdvantageApi\Requests\GetSearchRequest;
use Chip\ComplyAdvantageApi\Requests\UpdateSearchRequest;
use Chip\ComplyAdvantageApi\Requests\UpdateSearchEntityRequest;
use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use Chip\ComplyAdvantageApi\Responses\CreateSearchResponse;
use Chip\ComplyAdvantageApi\Responses\GetSearchResponse;
use Chip\ComplyAdvantageApi\Responses\GetSearchDetailsResponse;
use Chip\ComplyAdvantageApi\Responses\UpdateSearchResponse;
use GuzzleHttp\Client;
use Exception;
use DateTime;

class ComplyAdvantageApi
{
    /** @var string */
    private $key;

    private $http;

    private const BASE_URL = "https://api.complyadvantage.com";

    public function __construct(string $key, Client $http = null)
    {
        $this->http = $http;
        $this->key = $key;
    }

    // Create a new search by POSTing search terms, parameters and filters. 
    // By default creating a search will pull the first 100 results (if that many exist) from our database
    public function createSearch(CreateSearchRequest $request): ?CreateSearchResponse
    {
        try {
            $response = $this->http()->request('POST', '/searches?api_key=' . $this->key, [ "json" => $request->toArray() ]);

            if ($response->getBody()) {
                return new CreateSearchResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Update the assignee, status or risk level of a search.
    public function updateSearch(string $id, UpdateSearchRequest $request): ?UpdateSearchResponse
    {
        try {
            $response = $this->http()->request('PATCH', '/searches/' . $id . '?api_key=' . $this->key, [ "json" => $request->toArray() ]);

            if ($response->getBody()) {
                return new UpdateSearchResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Update the match-status of entities within a search result
    public function updateSearchEntities(string $id, UpdateSearchEntityRequest $request): ?UpdateSearchResponse
    {
        try {
            $response = $this->http()->request('PATCH', '/searches/' . $id . '/entities?api_key=' . $this->key, [ "json" => $request->toArray() ]);

            if ($response->getBody()) {
                return new UpdateSearchResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve the previous searches on your account. This includes many options for pagination and filtering results.
    public function getSearch(GetSearchRequest $request): ?GetSearchResponse
    {
        try {

            $url = '/searches/?api_key=' . $this->key;

            if ($request->countParams() > 0) {
                $url .= '&' . $request->toUrl();
            }

            $response = $this->http()->request('GET', $url);

            if ($response->getBody()) {
                return new GetSearchResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve a specific search on your account. 
    // For monitored searches, the original result will be updated with the latest results from the monitor runs.
    public function getSearchById(string $id): ?GetSearchResponse
    {
        try {
            $response = $this->http()->request('GET', '/searches/' . $id . '?api_key=' . $this->key);

            if ($response->getBody()) {
                return new GetSearchResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve the full details and results of a specific search on your account.
    public function getSearchDetailsById(string $id): ?GetSearchDetailsResponse
    {
        try {
            $response = $this->http()->request('GET', '/searches/' . $id . '/details?api_key=' . $this->key);

            if ($response->getBody()) {
                return new GetSearchDetailsResponse($this->asArray((string) $response->getBody()));
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve the differences on the monitored search on a specific date.
    public function getSearchUpdates(string $id, DateTime $date = null): ?array
    {
        try {
            $url = '/searches/' . $id . '/monitor/differences?api_key=' . $this->key;

            if ($date !== null) {
                $url .= '&date=' . date_format($date, 'Y-m-d');
            }
            $response = $this->http()->request('GET', $url);

            if ($response->getBody()) {
                return $this->asArray((string) $response->getBody());
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve a specific search certificate as a PDF file on your account.
    public function getCertificateById(string $id): ?string
    {
        try {
            $response = $this->http()->request('GET', '/searches/' . $id . '/certificate?api_key=' . $this->key);

            if ($response->getBody()) {
                return (string) $response->getBody();
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    private function http(): Client
    {
        if ($this->http !== null) {
            return $this->http;
        }

        return new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 2.0
        ]);
    }

    private function asArray(string $json): array
    {
        return json_decode(json_encode(json_decode($json)), true);
    }
}