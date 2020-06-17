<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\TypeFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class TypeFilterTest extends TestCase
{
    private const TYPES = [
        'sanction',
        'warning',
        'fitness-probity'
    ];

    public function testCanInstWithConstructor()
    {
        $filter = new TypeFilter(self::TYPES);
        $this->assertEquals(self::TYPES, $filter->getValue());
    }

    public function testCanInstFromArray()
    {
        $filter = TypeFilter::fromArray(self::TYPES);
        $this->assertEquals(self::TYPES, $filter->getValue());
    }

    public function testCanUseSetter()
    {
        $filter = new TypeFilter(self::TYPES);
        $filter->addType('pep-class-1');

        $expected = array_merge(self::TYPES, ['pep-class-1']);
        $this->assertEquals($expected, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new TypeFilter([]);
    }
}