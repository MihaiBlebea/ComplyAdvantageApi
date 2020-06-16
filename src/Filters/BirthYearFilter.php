<?php

use Chip\ComplyAdvantageApi\Filters\Filter;

class BirthYearFilter implements Filter
{
    /** @var string */
    private $year;

    private const NAME = "BirthYearFilter";

    public function __construct(string $year)
    {
        $this->year = $year;
    }

    public static function fromInt(int $year)
    {
        return new BirthYearFilter((string) $year);
    }

    public static function fromString(string $year)
    {
        return new BirthYearFilter($year);
    }

    public function getValue()
    {
        return $this->year;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}