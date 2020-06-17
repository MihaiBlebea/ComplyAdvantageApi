<?php

namespace Chip\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Chip\ComplyAdvantageApi\Filters\CreatedTimeFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use DateTime;

class CreatedTimeFilterTest extends TestCase
{
    private const FROM = '23/05/2019';

    private const EXPECTED_FROM = '2019-05-23';

    private const TO = '23/05/2020';

    private const EXPECTED_TO = '2020-05-23';

    public function testCanInstWithConstructor()
    {
        $fromDate = DateTime::createFromFormat('d/m/Y', self::FROM);
        $toDate = DateTime::createFromFormat('d/m/Y', self::TO);

        $filter = new CreatedTimeFilter([
            'from' => $fromDate,
            'to' => $toDate
        ]);
        $this->assertEquals(self::EXPECTED_FROM, $filter->getValue()['created_at_from']);
        $this->assertEquals(self::EXPECTED_TO, $filter->getValue()['created_at_to']);
    }

    public function testCanProvideJustFrom()
    {
        $fromDate = DateTime::createFromFormat('d/m/Y', self::FROM);

        $filter = new CreatedTimeFilter([
            'from' => $fromDate
        ]);
        $this->assertEquals(self::EXPECTED_FROM, $filter->getValue()['created_at_from']);
        $this->assertArrayNotHasKey('to', $filter->getValue());
    }

    public function testThrowException()
    {
        $this->expectException(InvalidFilterException::class);

        new CreatedTimeFilter([]);
    }

    public function testThrowExceptionIfFromAfterTo()
    {
        $this->expectException(InvalidFilterException::class);

        $fromDate = DateTime::createFromFormat('d/m/Y', '23/07/2020');
        $toDate = DateTime::createFromFormat('d/m/Y', self::TO);

        new CreatedTimeFilter([
            'from' => $fromDate,
            'to' => $toDate
        ]);
    }
}