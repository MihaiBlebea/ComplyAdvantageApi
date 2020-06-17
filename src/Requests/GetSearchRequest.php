<?php

namespace Chip\ComplyAdvantageApi\Requests;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;
use Chip\ComplyAdvantageApi\Filters\RiskLevelFilter;
use Chip\ComplyAdvantageApi\Filters\MatchStatusFilter;
use Chip\ComplyAdvantageApi\Filters\SearchTermFilter;

class GetSearchRequest
{
    /** @var array */
    private $params;

    public function __construct(array $params = null)
    {
        if ($params === null) {
            $this->params = [];
        }

        $this->params = $params;

        if (array_key_exists('risk_level', $params)) {
            $this->setFilters(RiskLevelFilter::fromArray($params['risk_level']));
        }

        if (array_key_exists('match_status', $params)) {
            $this->setFilters(MatchStatusFilter::fromArray($params['match_status']));
        }

        if (array_key_exists('search_term', $params)) {
            $this->setFilters(SearchTermFilter::fromString($params['search_term']));
        }
    }

    public function setPagination(int $offset, int $limit)
    {
        $this->params['page'] = $offset;
        $this->params['per_page'] = $limit;
    }

    public function setSorting(string $sortBy, bool $descending = true)
    {
        $this->params['sort_by'] = $sortBy;
        $this->params['sort_dir'] = $descending ? 'desc' : 'asc';
    }

    public function setFilters(Filter ...$filters)
    {
        foreach ($filters as $filter) {
            switch ($filter->getName()) {
                case 'RiskLevelFilter':
                    $this->params['risk_level'] = implode(',', $filter->getValue());
                    break;
                case 'MatchStatusFilter':
                    $this->params['match_status'] = implode(',', $filter->getValue());
                    break;
                case 'CreatedTimeFilter':
                    if (array_key_exists('created_at_from', $filter->getValue())) {
                        $this->params['created_at_from'] = $filter->getValue()['created_at_from'];
                    }

                    if (array_key_exists('created_at_to', $filter->getValue())) {
                        $this->params['created_at_to'] = $filter->getValue()['created_at_to'];
                    }
                    break;
                case 'SearchTermFilter':
                    $this->params['search_term'] = $filter->getValue();
                    break;
                default:
                    throw new InvalidFilterException('Invalid filter with name ' . $filter->getName());
            }
        }
    }

    public function toUrl(): string
    {
        $params = [];
        foreach ($this->params as $key => $param) {
            array_push($params, $key . "=" . $param);
        }
        return implode('&', $params);
    }

    public function toArray(): array
    {
        return $this->params;
    }

    public function countParams(): int
    {
        return count($this->params);
    }
}