<?php

namespace Chip\Tests\Requests;

use Chip\ComplyAdvantageApi\ComplyAdvantageApi;
use Chip\ComplyAdvantageApi\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class GetCertificateTest extends TestCase
{
    private const SUCCESS_RESPONSE = "This is a byte array that can be converted into a pdf. Magic.";

    public function testSearchByIdSuccess()
    {   
        $mock = new MockHandler([
            new Response(200, [], self::SUCCESS_RESPONSE)
        ]);
        
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $complyAdvantageApi = new ComplyAdvantageApi('abcd', $client);

        $response = $complyAdvantageApi->getCertificateById('1495711341-Tu51KL9s');

        $this->assertEquals(self::SUCCESS_RESPONSE, $response);
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

        $complyAdvantageApi->getSearchById('1495711341-Tu51KL9s22222');
    }
}