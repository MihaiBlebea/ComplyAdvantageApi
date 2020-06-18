<?php

namespace Chip\Tests\Requests;

use Chip\ComplyAdvantageApi\ComplyAdvantageApi;
use Chip\ComplyAdvantageApi\Requests\CreateSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class CreateSearchTest extends TestCase
{
    private const SUCCESS_RESPONSE = [
        'content' => [
            'data' => [
                'id' => 332903248,
                'ref' => '1592473789-MDQnEylH',
                'searcher_id' => 9880,
                'assignee_id' => 9880,
                'filters' => [
                    'country_codes' => ['RO'],
                    'remove_deceased'=> 0,
                    'types' => ['sanction', 'warning'],
                    'exact_match' => false,
                    'fuzziness' => 0.5
                ],
                'risk_level' => 'unknown',
                'match_status' => 'no_match',
                'search_term' => 'Catalina Enache',
                'submitted_term' => 'Catalina Enache',
                'client_ref' => 'CHIP_001',
                'total_hits' => 0,
                'updated_at' => '2020-06-18 09:49:49',
                'created_at' => '2020-06-18 09:49:49',
                'tags' => [],
                'labels' => [],
                'limit' => 100,
                'offset' => 0,
                'share_url' => 'https://app.complyadvantage.com/public/search/1592473789-MDQnEylH/0b2d8b0b406f',
                'searcher' => [
                    'id' => 9880,
                    'email' => 'internaldev@getchip.uk',
                    'name' => 'DEV Sandbox',
                    'phone' => '',
                    'created_at' => '2020-06-15 17:13:40'
                ],
                'assignee' => [
                    'id' => 9880,
                    'email' => 'internaldev@getchip.uk',
                    'name' => 'DEV Sandbox',
                    'phone' => '',
                    'created_at' => '2020-06-15 17:13:40'
                ],
                'hits' => 0
            ]
        ]
    ];

    public function testNoHits()
    {   
        $mock = new MockHandler([
            new Response(200, ['Accept' => 'application/json'], json_encode(self::SUCCESS_RESPONSE))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client([ 
            'handler' => $handlerStack ,
            'headers' => ['Accept' => 'application/json']
        ]);

        $complyAdvantageApi = new ComplyAdvantageApi('abcd', $client);

        $response = $complyAdvantageApi->createSearch(new CreateSearchRequest([
            'search_term' => [
                'first_name' => 'Catalina',
                'last_name' => 'Enache'
            ],
            'fuzziness' => 0.5,
            'filters' => [
                'types'=> ['sanction', 'warning']
            ],
            'share_url' => 1
        ]));

        $this->assertEquals(0, $response->getHitsCount());
        $this->assertEquals([], $response->getHits());
        $this->assertEquals(332903248, $response->getId());
        $this->assertEquals('1592473789-MDQnEylH', $response->getRef());
        $this->assertEquals('no_match', $response->getMatchStatus());
        $this->assertEquals('unknown', $response->getRiskLevel());
    }

    public function testFailedRequest()
    {   
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new Request('GET', 'failing'))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client([ 
            'handler' => $handlerStack ,
            'headers' => ['Accept' => 'application/json']
        ]);

        $complyAdvantageApi = new ComplyAdvantageApi('abcd', $client);

        $this->expectException(ApiException::class);

        $response = $complyAdvantageApi->createSearch(new CreateSearchRequest([
            'search_term' => [
                'first_name' => 'Catalina',
                'last_name' => 'Enache'
            ]
        ]));
    }
}