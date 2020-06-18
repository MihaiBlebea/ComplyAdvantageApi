<?php

namespace Chip\Tests\Requests;

use Chip\ComplyAdvantageApi\ComplyAdvantageApi;
use Chip\ComplyAdvantageApi\Requests\GetSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class GetSearchTest extends TestCase
{
    private const SUCCESS_RESPONSE = [
        'content' => [
            'data' => [
                'id' => 20,
                'ref' => '1495711341-Tu51KL9s',
                'searcher_id' => 1,
                'assignee_id' => 14,
                'filters' => [
                    'exact_match' => false,
                    'fuzziness' => 1,
                ],
                'match_status' => 'potential_match',
                'risk_level' => 'medium',
                'search_term' => 'Hugo Jinkis',
                'total_hits' => 1,
                'updated_at' => '2015-06-16 09:58:22',
                'created_at' => '2015-06-11 15:02:30',
            ],
            [
                'id' => 18,
                'ref' => '1495711341-TuJJDF9s',
                'searcher_id' => 1,
                'assignee_id' => 1,
                'filters' => [
                    'exact_match' => false,
                    'fuzziness' => 1,
                ],
                'match_status' => 'potential_match',
                'risk_level' => 'high',
                'search_term' => 'Vladimir Putin',
                'total_hits' => 7,
                'updated_at' => '2015-06-16 17:12:50',
                'created_at' => '2015-06-11 14:45:11',
            ]
        ]
    ];

    public function testNoHits()
    {   
        $mock = new MockHandler([
            new Response(200, [], json_encode(self::SUCCESS_RESPONSE))
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $complyAdvantageApi = new ComplyAdvantageApi('abcd', $client);

        $request = new GetSearchRequest([
            'risk_level' => ['high', 'medium'],
            'match_status' => ['potential_match']
        ]);

        $response = $complyAdvantageApi->getSearch($request);

        $this->assertEquals(self::SUCCESS_RESPONSE['content'], $response->getContent());
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

        $request = new GetSearchRequest([
            'risk_level' => ['high', 'medium'],
            'match_status' => ['potential_match']
        ]);

        $complyAdvantageApi->getSearch($request);
    }
}