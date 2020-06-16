<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;

class CountryFilter implements Filter
{
    /** @var array */
    private $countries;

    private const NAME = "CountryFilter";

    public function __construct(array $countries)
    {
        foreach($countries as $country) {
            if ($this->isValid($country) === false) {
                throw new InvalidFilterException("Country filter for " . $country . " is invalid");
            }
        }
        $this->countries = $countries;
    }

    public static function fromArray(array $countries)
    {
        return new CountryFilter($countries);
    }

    public function addCountry(string $country)
    {
        if ($this->isValid($country) === false) {
            throw new InvalidFilterException("Country filter for " . $country . " is invalid");
        }
        $this->countries[] = $country;
    }

    private function isValid(string $country)
    {
        return strlen($country) === 2;
    }

    public function getValue()
    {
        return $this->params;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}