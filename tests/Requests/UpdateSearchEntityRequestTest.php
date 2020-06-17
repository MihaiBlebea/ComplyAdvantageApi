<?php

namespace Chip\Tests\Requests;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Requests\UpdateSearchEntityRequest;

class UpdateSearchEntityRequestTest extends TestCase
{
    private const KEYS = [
        'match_status',
        'risk_level',
        'assignee_id',
        'is_whitelisted',
        'entities'
    ];

    private function assertHasKeys(array $body)
    {
        foreach (self::KEYS as $key) {
            $this->assertArrayHasKey($key, $body);
        }
    }

    public function testCanInstWithConstructor()
    {
        $request = new UpdateSearchEntityRequest([
            'match_status' => 'no_match',
            'risk_level' => 'medium',
            'assignee_id' => 1,
            'is_whitelisted' => true,
            'entities' => ['1234', '12345']
        ]);

        $this->assertHasKeys($request->toArray());
    }

    public function testCanUseSetters()
    {
        $request = new UpdateSearchEntityRequest();

        $request->setMatchStatus('no_match');
        $request->setRiskLevel('medium');
        $request->setAssigneeId(1);
        $request->setWhitelist(true);
        $request->setEntities(['1234', '12345']);

        $this->assertHasKeys($request->toArray());
    }
}