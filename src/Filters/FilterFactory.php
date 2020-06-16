<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Filters\BirthYearFilter;
use Chip\ComplyAdvantageApi\Filters\CountryFilter;
use Chip\ComplyAdvantageApi\Filters\TypeFilter;
use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;

class FilterFactory
{
    public static function build(string $filterName, $params): Filter
    {
        switch ($filterName) {
            case 'BirthYearFilter':
                return new BirthYearFilter($params);
            case 'CountryFilter':
                return new CountryFilter($params);
            case 'TypeFilter':
                return new TypeFilter($params);
            default:
                throw new InvalidFilterException('Invalid filter with name ' . $filterName);
        }
    }
}