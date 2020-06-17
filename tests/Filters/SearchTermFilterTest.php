<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\SearchTermFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class SearchTermFilterTest extends TestCase
{
    private const TERMS = 'Ser';

    public function testCanInstWithConstructor()
    {
        $filter = new SearchTermFilter(self::TERMS);
        $this->assertEquals(self::TERMS, $filter->getValue());
    }

    public function testCanInstFromArray()
    {
        $filter = SearchTermFilter::fromString(self::TERMS);
        $this->assertEquals(self::TERMS, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new SearchTermFilter('Se');
    }
}