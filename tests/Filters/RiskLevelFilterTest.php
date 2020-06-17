<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\RiskLevelFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class RiskLevelFilterTest extends TestCase
{
    private const LEVELS = [
        'medium', 
        'high', 
        'unknown'
    ];

    public function testCanInstWithConstructor()
    {
        $filter = new RiskLevelFilter(self::LEVELS);
        $this->assertEquals(self::LEVELS, $filter->getValue());
    }

    public function testCanInstFromArray()
    {
        $filter = RiskLevelFilter::fromArray(self::LEVELS);
        $this->assertEquals(self::LEVELS, $filter->getValue());
    }

    public function testCanUseSetter()
    {
        $filter = new RiskLevelFilter(self::LEVELS);
        $filter->addLevel('low');

        $expected = array_merge(self::LEVELS, ['low']);
        $this->assertEquals($expected, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new RiskLevelFilter([]);
    }
}