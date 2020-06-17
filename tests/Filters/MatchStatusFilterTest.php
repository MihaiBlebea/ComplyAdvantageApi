<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\MatchStatusFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class MatchStatusFilterTest extends TestCase
{
    private const STATUSES = [
        'no_match', 
        'false_positive', 
        'potential_match'
    ];

    public function testCanInstWithConstructor()
    {
        $filter = new MatchStatusFilter(self::STATUSES);
        $this->assertEquals(self::STATUSES, $filter->getValue());
    }

    public function testCanInstFromArray()
    {
        $filter = MatchStatusFilter::fromArray(self::STATUSES);
        $this->assertEquals(self::STATUSES, $filter->getValue());
    }

    public function testCanUseSetter()
    {
        $filter = new MatchStatusFilter(self::STATUSES);
        $filter->addStatus('unknown');

        $expected = array_merge(self::STATUSES, ['unknown']);
        $this->assertEquals($expected, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new MatchStatusFilter([]);
    }
}