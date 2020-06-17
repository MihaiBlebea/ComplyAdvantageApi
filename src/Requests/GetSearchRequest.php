<?php

namespace Chip\ComplyAdvantageApi\Requests;

use Chip\ComplyAdvantageApi\Exceptions\InvalidFilterException;
use Chip\ComplyAdvantageApi\Filters\Filter;

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
        return implode('&', array_values($this->params));
    }

    public function countParams(): int
    {
        return count($this->params);
    }
}