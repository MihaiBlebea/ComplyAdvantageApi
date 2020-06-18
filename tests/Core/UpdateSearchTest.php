<?php

namespace Chip\Tests\Requests;

use Chip\ComplyAdvantageApi\ComplyAdvantageApi;
use Chip\ComplyAdvantageApi\Requests\UpdateSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class UpdateSearchTest extends TestCase
{
    private const SUCCESS_RESPONSE = [
        'content' => [
            'data' => [
                'id' => 20,
                'ref' => '1495711341-Tu51KL9s',
                'searcher_id' => 1,
                'assignee_id' => 123,
                'tags' => [
                    'MyTagName' => 'MyTagValue',
                ],
                'labels' => [
                    0 => [
                        'type' => 'tag',
                        'name' => 'MyTagName',
                        'value' => 'MyTagValue',
                    ],
                ],
                'search_profile' => [
                    'name' => 'My USA Profile 1',
                    'slug' => 'my-usa-profile-1',
                ],
                'filters' => [
                    'exact_match' => false,
                    'fuzziness' => 1,
                ],
                'match_status' => 'true_positive',
                'risk_level' => 'high',
                'search_term' => 'Hugo Jinkis',
                'total_hits' => 1,
                'updated_at' => '2015-06-18 09:35:06',
                'created_at' => '2015-06-11 15:02:30',
            ],
        ],
    ];

    public function testCreateSuccessfullSearch()
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

        $request = new UpdateSearchRequest();

        $request->setMatchStatus('true_positive');
        $request->setRiskLevel('high');
        $request->setWhitelist(false);

        $response = $complyAdvantageApi->updateSearch('1495711341-Tu51KL9s', $request);

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

        $request = new UpdateSearchRequest();

        $request->setMatchStatus('true_positive');
        $request->setRiskLevel('high');
        $request->setWhitelist(false);

        $complyAdvantageApi->updateSearch('1495711341-Tu51KL9s222', $request);
    }
}