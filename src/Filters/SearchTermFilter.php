<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class SearchTermFilter implements Filter
{
    /** @var string */
    private $term;

    private const NAME = "SearchTermFilter";

    public function __construct(string $term)
    {
        if ($this->isValid($term) === false) {
            throw new InvalidFilterException("Filter search term " . $term . " is invalid");
        }

        $this->term = $term;
    }

    private function isValid(string $term)
    {
        return strlen($term) > 2;;
    }

    public static function fromString(string $term)
    {
        return new SearchTermFilter($term);
    }

    public function getValue()
    {
        return $this->term;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}