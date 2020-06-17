<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\BirthYearFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class BirthYearFilterTest extends TestCase
{
    private const YEAR = '1989';

    public function testCanInstWithConstructor()
    {
        $filter = new BirthYearFilter(self::YEAR);
        $this->assertEquals(self::YEAR, $filter->getValue());
    }

    public function testCanInstFromString()
    {
        $filter = BirthYearFilter::fromString(self::YEAR);
        $this->assertEquals(self::YEAR, $filter->getValue());
    }

    public function testCanInstFromInt()
    {
        $filter = BirthYearFilter::fromString(1989);
        $this->assertEquals(self::YEAR, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new BirthYearFilter('20202');
    }
}