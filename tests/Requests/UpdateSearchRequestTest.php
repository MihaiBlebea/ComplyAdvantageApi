<?php

namespace Chip\Tests\Requests;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\SearchTerm;
use Chip\ComplyAdvantageApi\Filters\FilterFactory;
use Chip\ComplyAdvantageApi\Requests\UpdateSearchRequest;
use Chip\ComplyAdvantageApi\Exceptions\InvalidCreateException;

class UpdateSearchRequestTest extends TestCase
{
    private const KEYS = [
        'match_status',
        'risk_level',
        'assignee_id',
        'is_whitelisted'
    ];

    private function assertHasKeys(array $body)
    {
        foreach (self::KEYS as $key) {
            $this->assertArrayHasKey($key, $body);
        }
    }

    public function testCanInstWithConstructor()
    {
        $request = new UpdateSearchRequest([
            'match_status' => 'no_match',
            'risk_level' => 'medium',
            'assignee_id' => 1,
            'is_whitelisted' => true,
        ]);

        $this->assertHasKeys($request->toArray());
    }

    public function testCanUseSetters()
    {
        $request = new UpdateSearchRequest();

        $request->setMatchStatus('no_match');
        $request->setRiskLevel('medium');
        $request->setAssigneeId(1);
        $request->setWhitelist(true);

        $this->assertHasKeys($request->toArray());
    }
}