<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class BirthYearFilter implements Filter
{
    /** @var string */
    private $year;

    private const NAME = "BirthYearFilter";

    public function __construct(string $year)
    {
        if ($this->isValid($year) === false) {
            throw new InvalidFilterException("Birth Year filter for " . $year . " is invalid");
        }
        $this->year = $year;
    }

    private function isValid(string $year)
    {
        return strlen($year) === 4;
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