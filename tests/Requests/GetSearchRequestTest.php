<?php

namespace Chip\Tests\Requests;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\FilterFactory;
use Chip\ComplyAdvantageApi\Requests\GetSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class GetSearchRequestTest extends TestCase
{
    private const KEYS = [
        'risk_level',
        'match_status',
        'created_at_from',
        'created_at_to',
        'search_term',
        'sort_by',
        'sort_dir',
        'page',
        'per_page'
    ];

    private function assertHasKeys(array $body)
    {
        foreach (self::KEYS as $key) {
            $this->assertArrayHasKey($key, $body);
        }
    }

    public function testCanInstWithConstructor()
    {
        $request = new GetSearchRequest([
            'risk_level'=> ['high', 'low'],
            'match_status' => ['false_positive', 'unknown'],
            'created_at_from' => '2019-05-23',
            'created_at_to' => '2020-05-23',
            'search_term' => 'ser',
            'sort_by' => 'id',
            'sort_dir' => 'desc',
            'page' => 1,
            'per_page' => 100
        ]);

        $this->assertHasKeys($request->toArray());
    }

    public function testCanCastAsUrl()
    {
        $request = new GetSearchRequest([
            'risk_level'=> ['high', 'low'],
            'match_status' => ['false_positive', 'unknown'],
            'created_at_from' => '2019-05-23',
            'created_at_to' => '2020-05-23',
            'search_term' => 'ser',
            'sort_by' => 'id',
            'sort_dir' => 'desc',
            'page' => 1,
            'per_page' => 100
        ]);
            
        $expected = <<<EOT
            risk_level=high,low
            &match_status=false_positive,unknown
            &created_at_from=2019-05-23
            &created_at_to=2020-05-23
            &search_term=ser
            &sort_by=id
            &sort_dir=desc
            &page=1
            &per_page=100
            EOT;
        $expected = trim(preg_replace('/\s+/', '', $expected));

        $this->assertEquals($expected, $request->toUrl());
    }
}