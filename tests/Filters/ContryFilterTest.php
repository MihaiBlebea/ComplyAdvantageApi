<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\CountryFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class CountryFilterTest extends TestCase
{
    private const COUNTRIES = ['RO', 'UK', 'US'];

    public function testCanInstWithConstructor()
    {
        $filter = new CountryFilter(self::COUNTRIES);
        $this->assertEquals(self::COUNTRIES, $filter->getValue());
    }

    public function testCanInstFromArray()
    {
        $filter = CountryFilter::fromArray(self::COUNTRIES);
        $this->assertEquals(self::COUNTRIES, $filter->getValue());
    }

    public function testCanUseSetter()
    {
        $filter = new CountryFilter(self::COUNTRIES);
        $filter->addCountry('NZ');

        $expected = array_merge(self::COUNTRIES, ['NZ']);
        $this->assertEquals($expected, $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new CountryFilter(['Romania']);
    }
}