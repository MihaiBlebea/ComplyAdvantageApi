<?php

namespace Chip\ComplyAdvantageApi\Filters;

use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Filters\BirthYearFilter;
use Chip\ComplyAdvantageApi\Filters\CountryFilter;
use Chip\ComplyAdvantageApi\Filters\TypeFilter;
use Chip\ComplyAdvantageApi\Filters\CreatedTimeFilter;
use Chip\ComplyAdvantageApi\Filters\MatchStatusFilter;
use Chip\ComplyAdvantageApi\Filters\RiskLevelFilter;
use Chip\ComplyAdvantageApi\Filters\SearchTermFilter;
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
            case 'CreatedTimeFilter':
                return new CreatedTimeFilter($params);
            case 'MatchStatusFilter':
                return new MatchStatusFilter($params);
            case 'RiskLevelFilter':
                return new RiskLevelFilter($params);
            case 'SearchTermFilter':
                return new SearchTermFilter($params);
            default:
                throw new InvalidFilterException('Invalid filter with name ' . $filterName);
        }
    }
}