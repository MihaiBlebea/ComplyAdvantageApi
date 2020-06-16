<?php

namespace Chip\ComplyAdvantageApi;

use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use GuzzleHttp\Client;
use Exception;
use DateTime;

class ComplyAdvantageApi
{
    /** @var string */
    private $key;

    private const BASE_URL = "https://api.complyadvantage.com";

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    // Create a new search by POSTing search terms, parameters and filters. 
    // By default creating a search will pull the first 100 results (if that many exist) from our database
    public function createSearch(array $options): ?array
    {
        try {
            $response = $this->http()->request('POST', '/searches?api_key=' . $this->key, [ "json" => $options ]);

            if ($response->getBody()) {
                return $this->asArray((string) $response->getBody())['content'];
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Update the assignee, status or risk level of a search.
    public function updateSearch(string $id, array $options): ?array
    {
        try {
            $response = $this->http()->request('PATCH', '/searches/' . $id . '?api_key=' . $this->key, [ "json" => $options ]);

            if ($response->getBody()) {
                return $this->asArray((string) $response->getBody())['content'];
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Update the match-status of entities within a search result
    public function updateSearchEntities(string $id, array $options): ?array
    {
        try {
            $response = $this->http()->request('PATCH', '/searches/' . $id . '/entities?api_key=' . $this->key, [ "json" => $options ]);

            if ($response->getBody()) {
                return $this->asArray((string) $response->getBody())['content'];
            }

            return null;
        } catch(Exception $e) {
            throw new ApiException($e->getMessage(), null);
        }
    }

    // Retrieve a specific search on your account. 
    // For monitored searches, the original result will be updated with the latest results from the monitor runs.
    public function getSearchById(string $id): ?array
    {
        try {
            $response = $this->http()->request('GET', '/searches/' . $id . '?api_key=' . $this->key);

            if ($response->getBody()) {
                return $this->asArray((string) $response->getBody())['content'];
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
                return $this->asArray((string) $response->getBody())['content'];
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
        return new Client([
            'base_uri' => self::BASE_URL,
            'timeout'  => 2.0,
            'headers' => ['Accept' => 'application/json'],
        ]);
    }

    private function asArray(string $json): array
    {
        return json_decode(json_encode(json_decode($json)), true);
    }
}